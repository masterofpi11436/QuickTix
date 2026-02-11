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

        // One consistent "now" and bounds for the entire seeding run
        $now = Carbon::now();
        $tenYearsAgo = (clone $now)->subYears(10);

        // Optional: cap timestamps to a max time-of-day (5pm today), never future
        $maxAt = (clone $now)->setTime(17, 0, 0);
        if ($maxAt->gt($now)) {
            $maxAt = clone $now;
        }

        for ($i = 0; $i < 1000; $i++) {
            $statusType = $faker->randomElement([
                StatusType::New,
                StatusType::InProgress,
                StatusType::Completed,
            ]);

            $submittedBy = $users->random();

            // created_at: within last 10 years, never after $maxAt
            $createdAt = Carbon::instance($faker->dateTimeBetween($tenYearsAgo, $maxAt));

            $assignedTo = null;
            $assignedBy = null;
            $assignedAt = null;
            $completedAt = null;

            // If completed, completion is 1 minute .. 5 weeks after created_at (but never future / after maxAt)
            if ($statusType === StatusType::Completed) {
                $minSeconds = 60;
                $maxSeconds = 5 * 7 * 24 * 60 * 60; // 5 weeks

                $candidateCompleted = (clone $createdAt)->addSeconds(
                    $faker->numberBetween($minSeconds, $maxSeconds)
                );

                // cap to maxAt (also ensures not in future)
                $completedAt = $candidateCompleted->gt($maxAt) ? clone $maxAt : $candidateCompleted;
            }

            // If not new, assign after created_at, and before completion (if any) or maxAt
            if ($statusType !== StatusType::New) {
                $assignedTo = $users->random();
                $assignedBy = $users->random();

                $assignedEnd = $completedAt ?? $maxAt;

                // guard against invalid range
                if ($createdAt->gte($assignedEnd)) {
                    $assignedAt = clone $createdAt;
                } else {
                    $assignedAt = Carbon::instance($faker->dateTimeBetween($createdAt, $assignedEnd));
                }
            }

            // updated_at: after created_at and <= maxAt (and if completed, keep it <= completedAt)
            $updatedEnd = $completedAt ?? $maxAt;
            $updatedAt = $createdAt->gte($updatedEnd)
                ? clone $createdAt
                : Carbon::instance($faker->dateTimeBetween($createdAt, $updatedEnd));

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

                'created_at' => $createdAt,
                'updated_at' => $updatedAt,

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
