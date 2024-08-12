<?php

namespace App\Constants;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
