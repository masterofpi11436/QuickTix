<?php

namespace Database\Seeders;

use App\Enums\StatusType;
use App\Models\Area;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\TicketTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        $departments = Department::query()->pluck('name')->all();
        if (empty($departments)) {
            $departments = [
                'Engineering',
                'Maintenance',
                'Quality Control',
                'Information Technology',
                'Human Resources',
            ];

            foreach ($departments as $name) {
                Department::create([
                    'name' => $name,
                    'description' => $faker->sentence(),
                ]);
            }
        }

        $areas = Area::query()->pluck('name')->all();
        if (empty($areas)) {
            $areas = [
                'Office',
                'Warehouse',
                'Shipping Dock',
                'Break Room',
                'Server Room',
                'Parking Lot',
                'Conference Room',
                'Production Floor',
            ];

            foreach ($areas as $name) {
                Area::create([
                    'name' => $name,
                    'description' => $faker->sentence(),
                ]);
            }
        }

        $users = User::query()->get();
        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create();
        }

        $templateIds = TicketTemplate::query()->pluck('id')->all();

        for ($i = 0; $i < 100; $i++) {
            $statusType = $faker->randomElement([
                StatusType::New,
                StatusType::InProgress,
                StatusType::Completed,
            ]);

            $submittedBy = $users->random();

            $assignedTo = null;
            $assignedBy = null;
            $assignedAt = null;
            $completedAt = null;

            if ($statusType !== StatusType::New) {
                $assignedTo = $users->random();
                $assignedBy = $users->random();
                $assignedAt = Carbon::now()
                    ->subDays($faker->numberBetween(0, 30))
                    ->subHours($faker->numberBetween(0, 12));
            }

            if ($statusType === StatusType::Completed && $assignedAt !== null) {
                $completedAt = (clone $assignedAt)->addHours($faker->numberBetween(1, 72));
            }

            Ticket::create([
                'ticket_template_id' => empty($templateIds) ? null : $faker->randomElement($templateIds),
                'title' => $faker->sentence(4),
                'description' => $faker->paragraphs(2, true),
                'notes' => $faker->boolean(70) ? $faker->paragraph() : null,

                'submitted_by_user_id' => $submittedBy->id,
                'submitted_by_name' => $this->formatName($submittedBy),

                'assigned_to_user_id' => $assignedTo?->id,
                'assigned_to_name' => $assignedTo ? $this->formatName($assignedTo) : null,

                'assigned_by_user_id' => $assignedBy?->id,
                'assigned_by_name' => $assignedBy ? $this->formatName($assignedBy) : null,

                'department' => $faker->randomElement($departments),
                'area' => $faker->randomElement($areas),

                'status_type' => $statusType->value,

                'assigned_at' => $assignedAt,
                'completed_at' => $completedAt,
            ]);
        }
    }

    private function formatName(User $user): string
    {
        $middle = trim((string) $user->middle_initial);
        if ($middle !== '') {
            return "{$user->first_name} {$middle}. {$user->last_name}";
        }

        return "{$user->first_name} {$user->last_name}";
    }
}
