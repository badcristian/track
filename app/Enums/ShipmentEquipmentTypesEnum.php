<?php

namespace App\Enums;

enum ShipmentEquipmentTypesEnum: string
{
    case reefer = 'R';
    case van = 'V';
    case flatbed = 'F';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
