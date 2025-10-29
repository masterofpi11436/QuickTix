<?php

namespace App\Enums;

enum UserRole: string
{
    case User = 'User';
    case Technician = 'Technician';
    case Controller = 'Controller';
    case Administrator = 'Administrator';
}
