<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SystemUpdateController extends Controller
{
    /**
     * Pull latest updates from GitHub and run database migrations.
     */
    public function update(Request $request)
    {
        try {
            // Increase execution time limit for git pull & migration
            @set_time_limit(180);

            // Execute git pull from main branch
            $gitOutput = shell_exec('git pull origin main 2>&1');

            // Run artisan migration safely
            Artisan::call('migrate', ['--force' => true]);
            $migrateOutput = Artisan::output();

            // Clear compiled views, cache, and config
            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            $trimmedOutput = trim($gitOutput ?? '');

            if (str_contains(strtolower($trimmedOutput), 'already up to date') || str_contains(strtolower($trimmedOutput), 'already up-to-date')) {
                return redirect()->back()->with('info', 'System is already up to date!');
            }

            return redirect()->back()->with('success', 'System updated successfully! Output: ' . $trimmedOutput);
        } catch (\Exception $e) {
            Log::error('System Update Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'System update failed: ' . $e->getMessage());
        }
    }
}
