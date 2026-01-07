<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@fintech.test'],
            [
                'first_name' => 'System',
                'last_name' => 'Admin',
                'password' => Hash::make('password'),
                'status' => 'active',
                'approved' => true,
                'address'        => 'System Address',
                'department'     => 'Administration',
                'avatar'         => null,
                'date_of_birth'  => '1990-01-01',
                'place_of_work'  => 'Head Office',
                'phone'          => '0000000000',
                'sex'            => 'male',
                
            ]
        );

        $admin->assignRole('admin');
    }
}
