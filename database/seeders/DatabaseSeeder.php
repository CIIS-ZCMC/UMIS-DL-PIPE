<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Devices;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Devices::create([
            'device_name' => "BUCAS-CENTER (ZCMC-WMSU)",
            'ip_address' => "192.168.5.159",
            'com_key' => "0",
            'soap_port' => "80",
            'udp_port' => "4370",
            'serial_number' => "",
            'mac_address' => "",
            'is_registration' => 0,
            'is_stable' => 1,
            'for_attendance' => 0,
            'receiver_by_default' => 0,
            'is_active' => 1
        ]);
    }
}
