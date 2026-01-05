<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\User;
use App\Models\Status;
use App\Models\Ticket;
use App\Enums\StatusType;
use App\Models\Department;
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
            'middle_initial' => 'A',
            'last_name' => 'Tuggle',
            'role' => 'Administrator',
            'theme' => 'dark',
            'email' => 'admin@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);

        User::factory()->create([
            'first_name' => 'John',
            'middle_initial' => 'A',
            'last_name' => 'Doe',
            'role' => 'Controller',
            'theme' => 'dark',
            'email' => 'cont1@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);

        User::factory()->create([
            'first_name' => 'Michael',
            'middle_initial' => '',
            'last_name' => 'Shumaker',
            'role' => 'Controller',
            'theme' => 'dark',
            'email' => 'cont2@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);

        User::factory()->create([
            'first_name' => 'Michael',
            'middle_initial' => 'D',
            'last_name' => 'Johnson',
            'role' => 'Technician',
            'theme' => 'dark',
            'email' => 'tech1@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);

        User::factory()->create([
            'first_name' => 'Samuel',
            'middle_initial' => 'L',
            'last_name' => 'Jackson',
            'role' => 'Technician',
            'theme' => 'dark',
            'email' => 'tech2@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);

        User::factory()->create([
            'first_name' => 'Jane',
            'middle_initial' => 'A',
            'last_name' => 'Doe',
            'role' => 'Technician',
            'theme' => 'dark',
            'email' => 'tech3@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);

        User::factory()->create([
            'first_name' => 'John',
            'middle_initial' => 'A',
            'last_name' => 'Smith',
            'role' => 'Reporting User',
            'theme' => 'dark',
            'email' => 'ruser@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);

        User::factory()->create([
            'first_name' => 'Jane',
            'middle_initial' => 'A',
            'last_name' => 'Smith',
            'role' => 'User',
            'theme' => 'dark',
            'email' => 'user@example.com',
            'password' => Hash::make('asd'),
            'last_logged_in_at' => null,
        ]);


        // -----------------------------
        // Areas (9)
        // -----------------------------
        Area::create(['name' => 'Area A', 'description' => 'Admin Area']);
        Area::create(['name' => 'Area B', 'description' => 'Staff Parking Lot']);
        Area::create(['name' => 'Area C', 'description' => 'Warehouse']);
        Area::create(['name' => 'Area D', 'description' => 'Lobby']);
        Area::create(['name' => 'Area E', 'description' => 'Mens Toilet']);
        Area::create(['name' => 'Area F', 'description' => 'Gym']);
        Area::create(['name' => 'Area G', 'description' => 'Security Booth']);
        Area::create(['name' => 'Area H', 'description' => 'Nurse Station']);
        Area::create(['name' => 'Area I', 'description' => 'Office Supply Closet']);


        // -----------------------------
        // Departments (5)
        // -----------------------------
        Department::create(['name' => 'Engineering', 'description' => 'Design and test new ideas.']);
        Department::create(['name' => 'Maintenance', 'description' => 'Fixes lights, toilets, and TVs']);
        Department::create(['name' => 'Quality Control', 'description' => 'Spot checks outgoing shipments']);
        Department::create(['name' => 'Information Technology', 'description' => 'Fixes Computers']);
        Department::create(['name' => 'Human Resource', 'description' => 'Hires and fires people. Looks out for the company, not the employee(s)']);


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
