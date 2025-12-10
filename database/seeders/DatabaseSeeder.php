<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Area;
use App\Models\Department;
use App\Models\Status;
use App\Enums\StatusType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -----------------------------
        // Users
        // -----------------------------
        User::factory()->create([
            'first_name' => 'Mark',
            'last_name' => 'Tuggle',
            'role' => 'Administrator',
            'theme' => 'dark',
            'email' => 'test@example.com',
            'password' => Hash::make('asd'),
        ]);

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'role' => 'Controller',
            'theme' => 'dark',
            'email' => 'test1@example.com',
            'password' => Hash::make('asd'),
        ]);

        User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Dow',
            'role' => 'Technician',
            'theme' => 'dark',
            'email' => 'test2@example.com',
            'password' => Hash::make('asd'),
        ]);

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'role' => 'ReportingUser',
            'theme' => 'dark',
            'email' => 'test3@example.com',
            'password' => Hash::make('asd'),
        ]);

        User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'role' => 'User',
            'theme' => 'dark',
            'email' => 'test4@example.com',
            'password' => Hash::make('asd'),
        ]);


        // -----------------------------
        // Areas (3)
        // -----------------------------
        Area::create(['name' => 'Manufacturing']);
        Area::create(['name' => 'Warehouse']);
        Area::create(['name' => 'Administration']);


        // -----------------------------
        // Departments (3)
        // -----------------------------
        Department::create(['name' => 'Engineering']);
        Department::create(['name' => 'Maintenance']);
        Department::create(['name' => 'Quality Control']);


        // -----------------------------
        // Statuses (3) using enum
        // -----------------------------
        Status::create([
            'name' => 'New',
            'color' => '#3490dc', // blue
            'status_type' => StatusType::Default,
        ]);

        Status::create([
            'name' => 'In Progress',
            'color' => '#f59e0b', // amber
            'status_type' => StatusType::InProgress,
        ]);

        Status::create([
            'name' => 'Completed',
            'color' => '#38a169', // green
            'status_type' => StatusType::Completed,
        ]);
    }
}
