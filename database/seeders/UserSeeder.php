<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::updateOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'role_id' => $admin->id,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone' => '01614694415',
                'is_approved' => true,
                'joining_date' => date('Y-m-d'),
                'joining_month' => date('F'),
                'joining_year' => date('Y'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ]
        );
        
        $vendor = Role::updateOrCreate(['slug' => 'vendor'], ['name' => 'Vendor']);
        User::updateOrCreate(
            ['username' => 'vendor'],
            [
                'role_id' => $vendor->id,
                'name' => 'Vendor',
                'email' => 'vendor@gmail.com',
                'phone' => '01303851066',
                'is_approved' => true,
                'joining_date' => date('Y-m-d'),
                'joining_month' => date('F'),
                'joining_year' => date('Y'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ]
        );

        $customer = Role::updateOrCreate(['slug' => 'customer'], ['name' => 'Customer']);
        User::updateOrCreate(
            ['username' => 'customer'],
            [
                'role_id' => $customer->id,
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'phone' => '01303851066',
                'is_approved' => true,
                'joining_date' => date('Y-m-d'),
                'joining_month' => date('F'),
                'joining_year' => date('Y'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ]
        );
    }
}
