<?php

namespace App\Constants;
use App\Traits\ConstantsTrait;

enum RoleConstants : string
{
    use ConstantsTrait;

    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';
    case HR = 'human resource';
    case TOP_MANAGEMENT = 'top management';
    case CUSTOMER = 'customer';
}
