<?php

namespace App\Enums;

enum StatusType: string
{
    case Default = 'default';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
