<?php

namespace App\Core\Enums;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
