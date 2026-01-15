<?php

namespace App\Enums;

enum StatusType: string
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
