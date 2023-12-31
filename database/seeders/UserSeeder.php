<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@reminex.com',
            'username' => 'admin_123',
            'department' => 'test-admin',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        DB::table('users')->insert([
            'name' => 'student',
            'email' => 'student@reminex.com',
            'username' => '012345',
            'department' => 'test-student',
            'role' => 'student',
            'password' => Hash::make('admin123'),
        ]);

        DB::table('users')->insert([
            'name' => 'teacher',
            'email' => 'teacher@reminex.com',
            'username' => '12345',
            'department' => 'test-faculty',
            'role' => 'teacher',
            'password' => Hash::make('admin123'),
        ]);

        \App\Models\User::where('email','admin@reminex.com')->first()->assignRole('admin');
        \App\Models\User::where('email','student@reminex.com')->first()->assignRole('student');
        \App\Models\User::where('email','teacher@reminex.com')->first()->assignRole('teacher');
    }
}
