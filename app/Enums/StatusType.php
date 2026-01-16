<?php

namespace App\Enums;

enum StatusType: string
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
        };
    }

    public function badgeColors(): string
    {
        return match ($this) {
            self::New => 'bg-blue-200 text-blue-800 dark:bg-blue-700 dark:text-blue-100',
            self::InProgress => 'bg-yellow-200 text-black dark:bg-yellow-300 dark:text-black',
            self::Completed => 'bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-100',
        };
    }
}
