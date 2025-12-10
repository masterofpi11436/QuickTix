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

        // -----------------------------
        // Tickets (3)
        // -----------------------------
        Ticket::create([
            'ticket_template_id' => null,
            'title' => 'Broken Conveyor Belt',
            'description' => 'The conveyor belt in lane 3 is jammed and producing smoke.',
            'notes' => 'Urgent priority. Machine was shut down for safety.',
            'submitted_by' => 'Mark Tuggle',
            'technician' => 'Jane Dow',
            'assigned_by' => 'John Doe',
            'department' => 'Maintenance',
            'area' => 'Manufacturing',
            'status' => 'In Progress',
            'opened' => Carbon::now()->subDays(2),
            'assigned' => Carbon::now()->subDay(),
            'completed' => null,
        ]);

        Ticket::create([
            'ticket_template_id' => null,
            'title' => 'Warehouse Lighting Failure',
            'description' => 'Half the overhead lights in section B are not turning on.',
            'notes' => 'Possible electrical issue. Operators are using portable lamps.',
            'submitted_by' => 'Jane Smith',
            'technician' => 'John Smith',
            'assigned_by' => 'John Doe',
            'department' => 'Engineering',
            'area' => 'Warehouse',
            'status' => 'In Progress',
            'opened' => Carbon::now()->subDays(3),
            'assigned' => Carbon::now()->subDays(2),
            'completed' => null,
        ]);

        Ticket::create([
            'ticket_template_id' => null,
            'title' => 'Finished Goods Labeling Issue',
            'description' => 'Barcodes are printing misaligned on batch #8841.',
            'notes' => 'Recalibration done; needs verification.',
            'submitted_by' => 'John Smith',
            'technician' => 'Jane Dow',
            'assigned_by' => 'Mark Tuggle',
            'department' => 'Quality Control',
            'area' => 'Administration',
            'status' => 'Completed',
            'opened' => Carbon::now()->subDays(5),
            'assigned' => Carbon::now()->subDays(4),
            'completed' => Carbon::now()->subDays(1),
        ]);
    }
}
