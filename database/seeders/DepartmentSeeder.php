<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            ['name' => 'La Paz', 'code' => 'LP'],
            ['name' => 'Cochabamba', 'code' => 'CB'],
            ['name' => 'Santa Cruz', 'code' => 'SC'],
            ['name' => 'Oruro', 'code' => 'OR'],
            ['name' => 'Potosí', 'code' => 'PT'],
            ['name' => 'Tarija', 'code' => 'TJ'],
            ['name' => 'Chuquisaca', 'code' => 'CH'],
            ['name' => 'Beni', 'code' => 'BE'],
            ['name' => 'Pando', 'code' => 'PD'],
        ];

        foreach ($departamentos as $departamento) {
            Department::create([
                'name' => $departamento['name'],
                'code' => $departamento['code'],
            ]);
        }
    }
}
