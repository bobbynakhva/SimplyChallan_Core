<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Display the backup and restore page.
     */
    public function index()
    {
        return view('backup.index');
    }

    /**
     * Export all relevant database tables to a ZIP file containing JSON data.
     */
    public function export()
    {
        $tables = [
            'users',
            'companies',
            'purposes',
            'financial_years',
            'inward_challans',
            'inward_challan_items',
            'challans',
            'challan_items',
            'goods_stock',
            'return_items'
        ];

        $data = [];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                // Get all rows from the table
                $rows = DB::table($table)->get()->toArray();
                
                // Convert stdClass objects to arrays
                $data[$table] = array_map(function($row) {
                    return (array) $row;
                }, $rows);
            }
        }

        $json = json_encode($data, JSON_PRETTY_PRINT);
        $timestamp = date('Y-m-d_H-i-s');
        $filename = 'backup_' . $timestamp . '.json';
        $zipFilename = 'simply_challan_backup_' . $timestamp . '.zip';

        // Save locally first
        Storage::disk('local')->put($filename, $json);

        $zip = new ZipArchive;
        $zipFilePath = storage_path('app/' . $zipFilename);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile(storage_path('app/' . $filename), $filename);
            $zip->close();
        }

        // Clean up the temporary JSON file
        Storage::disk('local')->delete($filename);

        if (!file_exists($zipFilePath)) {
            return back()->with('error', 'Could not create backup file.');
        }

        return response()->download($zipFilePath, $zipFilename)->deleteFileAfterSend(true);
    }

    /**
     * Restore database from a JSON or ZIP backup file.
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file'
        ]);

        $file = $request->file('backup_file');
        $content = '';

        $extension = $file->getClientOriginalExtension();

        if ($extension === 'zip') {
            $zip = new ZipArchive;
            if ($zip->open($file->getRealPath()) === TRUE) {
                // Try to find a JSON file in the zip
                $jsonFile = null;
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $name = $zip->getNameIndex($i);
                    if (pathinfo($name, PATHINFO_EXTENSION) === 'json') {
                        $jsonFile = $name;
                        break;
                    }
                }

                if ($jsonFile) {
                    $content = $zip->getFromName($jsonFile);
                } else {
                    $zip->close();
                    return back()->with('error', 'No JSON file found in ZIP archive.');
                }
                $zip->close();
            } else {
                return back()->with('error', 'Could not open ZIP file.');
            }
        } elseif ($extension === 'json') {
            $content = file_get_contents($file->getRealPath());
        } else {
            return back()->with('error', 'Invalid file type. Please upload a .zip or .json file.');
        }

        $data = json_decode($content, true);

        if (!$data || !is_array($data)) {
            return back()->with('error', 'Invalid backup file content or format.');
        }

        try {
            DB::beginTransaction();
            
            // Disable foreign key checks to allow truncation
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            foreach ($data as $table => $rows) {
                if (Schema::hasTable($table)) {
                    // Clear existing data
                    DB::table($table)->truncate();
                    
                    if (!empty($rows)) {
                        // Insert new data in chunks
                        foreach (array_chunk($rows, 200) as $chunk) {
                            DB::table($table)->insert($chunk);
                        }
                    }
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::commit();

            return redirect()->route('backup.index')->with('success', 'Data restored successfully from backup!');
        } catch (\Exception $e) {
            DB::rollBack();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            return back()->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }
}
