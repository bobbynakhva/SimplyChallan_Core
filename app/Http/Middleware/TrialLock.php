<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class TrialLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 0. Exempt License Management and Error Views
        if ($request->is('admin/license*') || $request->is('license-*') || $request->is('activate-license')) {
            return $next($request);
        }

        // 1. Mandatory License Check
        $licenseKey = \App\Services\LicenseService::getStoredKey();
        
        if (empty($licenseKey)) {
            // Block access immediately if no license is provided
            return response()->view('errors.license-invalid', [
                'machine_id' => \App\Services\LicenseService::getMachineId(),
                'reason' => 'A valid license key is required to start the application.'
            ], 403);
        }

        $licenseResult = \App\Services\LicenseService::validateLicense();

        if ($licenseResult['valid']) {
            // License is active and within 1 year!
            return $next($request);
        }

        // Handle specific failures
        if ($licenseResult['status'] === 'expired') {
            return response()->view('errors.license-expired', [
                'expiry_date' => $licenseResult['expiry_date']
            ], 403);
        }

        if ($licenseResult['status'] === 'wrong_machine') {
            return response()->view('errors.license-invalid', [
                'machine_id' => \App\Services\LicenseService::getMachineId(),
                'reason' => 'This key is already used on another computer.'
            ], 403);
        }

        // Fallback for general invalid
        return response()->view('errors.license-invalid', [
            'machine_id' => \App\Services\LicenseService::getMachineId()
        ], 403);
    }
}
