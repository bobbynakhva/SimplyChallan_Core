<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LicenseService;

class LicenseController extends Controller
{
    /**
     * Show the License Management page.
     * Accessible only by Admin.
     */
    public function index(Request $request)
    {
        // Simple security: only show if ?dev=SECRET is provided in URL
        // You can set LICENSE_MANAGEMENT_SECRET in your .env
        $secret = env('LICENSE_MANAGEMENT_SECRET', 'simply-admin-2026');
        
        if ($request->query('dev') !== $secret) {
            abort(404);
        }

        $currentMachineId = LicenseService::getMachineId();
        $currentKey = LicenseService::getStoredKey();
        
        $bindingPath = storage_path('app/license_bindings.json');
        $bindings = file_exists($bindingPath) ? json_decode(file_get_contents($bindingPath), true) : [];

        return view('admin.license.index', compact('currentMachineId', 'bindings', 'currentKey'));
    }

    /**
     * Activates the app using a license key.
     */
    public function activate(Request $request)
    {
        $request->validate(['license_key' => 'required|string']);
        $key = trim($request->license_key);
        
        // Save to obfuscated file (base64 encoded)
        file_put_contents(storage_path('app/.config_v2_manifest.dat'), base64_encode($key));
        
        // Optionally try to update .env if it exists
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $content = file_get_contents($envPath);
            if (str_contains($content, 'APP_LICENSE_KEY=')) {
                $content = preg_replace('/APP_LICENSE_KEY=.*/', 'APP_LICENSE_KEY=' . $key, $content);
            } else {
                $content .= "\nAPP_LICENSE_KEY=" . $key;
            }
            file_put_contents($envPath, $content);
        }

        return redirect()->route('home')->with('success', 'License activated successfully!');
    }

    /**
     * Unbinds a license key from its machine.
     */
    public function resetBinding(Request $request)
    {
        $request->validate(['license_key' => 'required|string']);
        $key = $request->license_key;

        $bindingPath = storage_path('app/license_bindings.json');
        if (file_exists($bindingPath)) {
            $bindings = json_decode(file_get_contents($bindingPath), true);
            if (isset($bindings[$key])) {
                unset($bindings[$key]);
                file_put_contents($bindingPath, json_encode($bindings));
                return back()->with('success', "License key $key has been reset and can be activated on a new machine.");
            }
        }

        return back()->withErrors(['message' => 'Key not found in active bindings.']);
    }
}
