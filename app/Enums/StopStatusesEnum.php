<?php

namespace App\Enums;

enum StopStatusesEnum: string
{
    case ready = 'ready';
    case done = 'done';
    case late = 'late';
    case cancelled = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
