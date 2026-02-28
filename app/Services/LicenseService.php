<?php

namespace App\Services;

use Carbon\Carbon;

class LicenseService
{
    /**
     * Generates a unique hardware signature for the current Windows machine.
     */
    /**
     * Generates a unique hardware signature for the current Windows machine.
     * Robust: Handles multiple drives and ensures consistent order.
     */
    public static function getMachineId()
    {
        try {
            // Get Disk Serials
            $output = shell_exec('wmic diskdrive get serialnumber');
            $serials = self::parseWmicOutput($output);
            
            if (empty($serials)) {
                // Fallback to Baseboard
                $output = shell_exec('wmic baseboard get serialnumber');
                $serials = self::parseWmicOutput($output);
            }

            // Stable: Sort them so order doesn't matter, join with a separator
            sort($serials);
            $signature = implode('|', $serials);

            return md5($signature . 'SimplySecretSalt');
        } catch (\Exception $e) {
            return 'UNSUPPORTED_HARDWARE';
        }
    }

    /**
     * Old, unstable logic kept for migrating existing users.
     */
    public static function getLegacyMachineId()
    {
        try {
            $serial = shell_exec('wmic diskdrive get serialnumber');
            $serial = str_replace("SerialNumber", "", $serial);
            $serial = trim($serial);
            
            if (empty($serial)) {
                $serial = shell_exec('wmic baseboard get serialnumber');
                $serial = str_replace("SerialNumber", "", $serial);
                $serial = trim($serial);
            }

            return md5($serial . 'SimplySecretSalt');
        } catch (\Exception $e) {
            return 'UNSUPPORTED_HARDWARE';
        }
    }

    private static function parseWmicOutput($output)
    {
        $lines = explode("\n", $output);
        $clean = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_contains(strtolower($line), 'serialnumber')) continue;
            $clean[] = $line;
        }
        return $clean;
    }

    /**
     * Gets the license key from Config or local storage.
     */
    public static function getStoredKey()
    {
        $key = config('app.license_key');
        if (empty($key)) {
            // Obfuscated file name and base64 encoding to prevent tampering
            $path = storage_path('app/.config_v2_manifest.dat');
            if (file_exists($path)) {
                $encodedKey = trim(file_get_contents($path));
                $key = base64_decode($encodedKey) ?: $encodedKey; // Fallback if not encoded
            }
        }
        return $key;
    }

    /**
     * Validates the provided license key.
     * Supports both Hardware-Specific keys and Bulk-Generated keys with 1-Year Expiry.
     */
    public static function validateLicense()
    {
        $storedKey = self::getStoredKey();
        if (empty($storedKey)) return ['valid' => false, 'status' => 'missing'];

        $machineId = self::getMachineId();
        $legacyMachineId = self::getLegacyMachineId();

        // 1. Check Hardware-Specific Key (Admin generated manually for this machine)
        $expectedHardwareKey = md5($machineId . 'AppGrowth2026'); 
        $legacyHardwareKey = md5($legacyMachineId . 'AppGrowth2026');

        if (hash_equals($expectedHardwareKey, $storedKey) || hash_equals($legacyHardwareKey, $storedKey)) {
            return ['valid' => true, 'status' => 'active'];
        }

        // 2. Check Bulk-Generated Keys (from licenses.txt / JSON)
        $storagePath = storage_path('app/valid_licenses.json');
        if (file_exists($storagePath)) {
            $validKeys = json_decode(file_get_contents($storagePath), true);
            if (is_array($validKeys) && in_array($storedKey, $validKeys)) {
                
                $bindingPath = storage_path('app/license_bindings.json');
                $bindings = file_exists($bindingPath) ? json_decode(file_get_contents($bindingPath), true) : [];
                
                if (isset($bindings[$storedKey])) {
                    $binding = $bindings[$storedKey];
                    
                    // Check if machine matches (Current vs Legacy)
                    $isMatch = ($binding['machine_id'] === $machineId);
                    $isLegacyMatch = ($binding['machine_id'] === $legacyMachineId);

                    if (!$isMatch && !$isLegacyMatch) {
                        return ['valid' => false, 'status' => 'wrong_machine'];
                    }

                    // Auto-migrate to the new stable Machine ID if it matched via Legacy
                    if (!$isMatch && $isLegacyMatch) {
                        $bindings[$storedKey]['machine_id'] = $machineId;
                        file_put_contents($bindingPath, json_encode($bindings));
                    }

                    // Check 1 year expiry (365 days)
                    $activatedAt = Carbon::parse($binding['activated_at']);
                    if (Carbon::now()->diffInDays($activatedAt) > 365) {
                        return ['valid' => false, 'status' => 'expired', 'expiry_date' => $activatedAt->addYear()->format('d-m-Y')];
                    }

                    return ['valid' => true, 'status' => 'active', 'expiry_date' => $activatedAt->addYear()->format('d-m-Y')];
                } else {
                    // First time use! Bind it to this machine with a 1-year start date
                    $bindings[$storedKey] = [
                        'machine_id' => $machineId,
                        'activated_at' => Carbon::now()->toDateTimeString(),
                    ];
                    file_put_contents($bindingPath, json_encode($bindings));
                    return ['valid' => true, 'status' => 'active', 'expiry_date' => Carbon::now()->addYear()->format('d-m-Y')];
                }
            }
        }
        
        return ['valid' => false, 'status' => 'invalid'];
    }
}
