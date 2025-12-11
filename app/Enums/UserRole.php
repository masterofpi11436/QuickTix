<?php

namespace App\Enums;

enum UserRole: string
{
    case User = 'User';
    case ReportingUser = 'Reporting User';
    case Technician = 'Technician';
    case Controller = 'Controller';
    case Administrator = 'Administrator';

    public function label(): string
    {
        return $this->value;
    }
}
