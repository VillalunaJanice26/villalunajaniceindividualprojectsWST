<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        Equipment::create([
            'name' => 'Desktop Computer',
            'category' => 'Computer Equipment',
            'serial_number' => 'PC-2026-001',
            'location' => 'Computer Laboratory',
            'status' => 'Available',
            'description' => 'Desktop computer for laboratory use.',
        ]);

        Equipment::create([
            'name' => 'Projector',
            'category' => 'Presentation Equipment',
            'serial_number' => 'PR-2026-001',
            'location' => 'Conference Room',
            'status' => 'In Use',
            'description' => 'Projector for presentations and meetings.',
        ]);

        Equipment::create([
            'name' => 'Printer',
            'category' => 'Office Equipment',
            'serial_number' => 'PT-2026-001',
            'location' => 'Admin Office',
            'status' => 'Under Maintenance',
            'description' => 'Printer currently undergoing maintenance.',
        ]);
    }
}