<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@ajatic.com',
        ]);

        $user->assignRole('administrator');

        $users = User::factory(20)->create();

        foreach ($users as $user) {
            $user->assignRole('supervisor');
        }

        $users = User::factory(50)->create();

        foreach ($users as $user) {
            $user->assignRole('operator');
        }

        $users = User::factory(10)->create();

        foreach ($users as $user) {
            $user->assignRole('checker');
        }
    }
}
