<?php

namespace App\Enums;

enum StopTypesEnum: string
{
    case pickup = 'pickup';
    case delivery = 'delivery';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
