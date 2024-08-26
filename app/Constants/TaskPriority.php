<?php

namespace App\Constants;

enum TaskPriority: string
{
    case LOW = 'LOW';
    case MEDIUM = 'MEDIUM';
    case HIGH = 'HIGH';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
