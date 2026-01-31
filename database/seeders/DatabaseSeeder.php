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
        // Departments (4)
        // -----------------------------
        Department::create(['name' => 'MIU', 'description' => 'IT department that handles IT related issues for the organization']);
        Department::create(['name' => 'Keefe', 'description' => 'Handles commissary']);
        Department::create(['name' => 'IC Solutions', 'description' => 'Handles inmate tablets and video visitation issues']);
        Department::create(['name' => 'Maintenance', 'description' => 'Handles plumbing and physical labor type of work']);


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
