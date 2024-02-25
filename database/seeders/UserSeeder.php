<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::create(['name' => 'Admin']);
        $hr_role = Role::create(['name' => 'HR']);
        $employee_role = Role::create(['name' => 'Employee']);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'HRMS',
            'email' => 'admin@hrms.app',
            'password' => 'password'
        ]);

        $admin->assignRole($admin_role);
    }
}
