<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LicenseSystemTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_machine_id_is_stable()
    {
        $id1 = \App\Services\LicenseService::getMachineId();
        $id2 = \App\Services\LicenseService::getMachineId();
        
        $this->assertEquals($id1, $id2, "Machine ID must be consistent across calls");
        $this->assertNotEmpty($id1);
    }

    public function test_activation_flow()
    {
        $user = \App\Models\User::first() ?: \App\Models\User::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $machineId = \App\Services\LicenseService::getMachineId();
        $secretToken = 'AppGrowth2026';
        $validKey = md5($machineId . $secretToken);

        // 1. Initially should be blocked (using an empty key)
        config(['app.license_key' => '']);
        if (file_exists(storage_path('app/.config_v2_manifest.dat'))) unlink(storage_path('app/.config_v2_manifest.dat'));

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(403);

        // 2. Perform Activation
        $response = $this->actingAs($user)->post(route('license.activate'), [
            'license_key' => $validKey
        ]);

        $response->assertRedirect();
        
        // 3. Verify it was saved to storage (obfuscated)
        $this->assertFileExists(storage_path('app/.config_v2_manifest.dat'));
        $storedValue = trim(file_get_contents(storage_path('app/.config_v2_manifest.dat')));
        $this->assertEquals($validKey, base64_decode($storedValue));

        // 4. Verify LicenseService now validates correctly
        $result = \App\Services\LicenseService::validateLicense();
        $this->assertTrue($result['valid']);
    }

    public function test_unauthorized_machine_is_blocked()
    {
        $user = \App\Models\User::first();
        
        $otherMachineId = 'SOME_OTHER_MACHINE_ID';
        $wrongMachineKey = md5($otherMachineId . 'AppGrowth2026');
        
        // 1. Must be in valid_licenses.json
        $validPath = storage_path('app/valid_licenses.json');
        $validKeys = file_exists($validPath) ? json_decode(file_get_contents($validPath), true) : [];
        $validKeys[] = $wrongMachineKey;
        file_put_contents($validPath, json_encode(array_unique($validKeys)));

        // 2. Must be bound to a different machine in license_bindings.json
        $bindingPath = storage_path('app/license_bindings.json');
        $bindings = file_exists($bindingPath) ? json_decode(file_get_contents($bindingPath), true) : [];
        $bindings[$wrongMachineKey] = [
            'machine_id' => $otherMachineId,
            'activated_at' => now()->toDateTimeString()
        ];
        file_put_contents($bindingPath, json_encode($bindings));

        // 3. Set as current key (obfuscated format)
        file_put_contents(storage_path('app/.config_v2_manifest.dat'), base64_encode($wrongMachineKey));
        config(['app.license_key' => $wrongMachineKey]);
        
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(403);
        $response->assertSee('Issue:</b> This key is already used on another computer.', false);
    }

    public function test_admin_license_page_requires_secret()
    {
        $user = \App\Models\User::first();

        // Without secret -> 404
        $response = $this->actingAs($user)->get(route('admin.license.index'));
        $response->assertStatus(404);

        // With secret -> 200
        $response = $this->actingAs($user)->get(route('admin.license.index') . '?dev=simply-admin-2026');
        $response->assertStatus(200);
    }
}
