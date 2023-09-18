<?php

namespace App\Enums;

enum TaskStatus: string
{
    const URGENT = 'URGENT';
    const HIGH = 'HIGH';
    const NORMAL = 'NORMAL';
    const LOW = 'LOW';

    public static function toArray(): array
    {
        return [
            self::URGENT,
            self::HIGH,
            self::NORMAL,
            self::LOW,
        ];
    }
}