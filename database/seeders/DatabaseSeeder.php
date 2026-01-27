<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use App\Enums\StatusType;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // Administrator
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

        // -----------------------------
        // Controllers
        // -----------------------------
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

        // -----------------------------
        // Technicians
        // -----------------------------
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

        // -----------------------------
        // Reporting User
        // -----------------------------
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

        // -----------------------------
        // User
        // -----------------------------
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
        // Departments (5)
        // -----------------------------
        Department::create(['name' => 'Engineering', 'description' => 'Design and test new ideas.']);
        Department::create(['name' => 'Maintenance', 'description' => 'Fixes lights, toilets, and TVs']);
        Department::create(['name' => 'Quality Control', 'description' => 'Spot checks outgoing shipments']);
        Department::create(['name' => 'Information Technology', 'description' => 'Fixes Computers']);
        Department::create(['name' => 'Human Resource', 'description' => 'Hires and fires people. Looks out for the company, not the employee(s)']);


        // -----------------------------
        // Statuses
        // -----------------------------
        $new = Status::create([
            'name' => 'New',
            'status_type' => StatusType::New,
        ]);

        $inProgress = Status::create([
            'name' => 'In Progress',
            'status_type' => StatusType::InProgress,
        ]);

        $completed = Status::create([
            'name' => 'Completed',
            'status_type' => StatusType::Completed,
        ]);

z
        // Status type defaults
        // -----------------------------
        DB::table('status_type_defaults')->updateOrInsert(
            ['status_type' => StatusType::New->value],
            ['status_id' => $new->id, 'created_at' => now(), 'updated_at' => now()]
        );

        DB::table('status_type_defaults')->updateOrInsert(
            ['status_type' => StatusType::InProgress->value],
            ['status_id' => $inProgress->id, 'created_at' => now(), 'updated_at' => now()]
        );

        DB::table('status_type_defaults')->updateOrInsert(
            ['status_type' => StatusType::Completed->value],
            ['status_id' => $completed->id, 'created_at' => now(), 'updated_at' => now()]
        );

        // -----------------------------
        // Ticket Templates (2)
        // -----------------------------
        DB::table('ticket_templates')->updateOrInsert(
            ['title' => 'Lightbulb Broken'],
            [
                'description' => 'Light Bulb in the office needs replacing.',
                'department_id' => 2,
                'area_id' => 12,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::table('ticket_templates')->updateOrInsert(
            ['title' => 'Lightbulb Broken'],
            [
                'description' => 'A computer or software issue needs IT assistance.',
                'department_id' => 2,
                'area_id' => 12,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
