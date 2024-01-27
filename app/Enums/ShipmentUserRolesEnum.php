<?php

namespace App\Enums;

enum ShipmentUserRolesEnum: string
{
    case driver = 'driver';
    case broker = 'broker';
    case dispatcher = 'dispatcher';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
