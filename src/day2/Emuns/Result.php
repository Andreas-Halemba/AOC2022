<?php

namespace App\day2\Emuns;

use Exception;

enum Result
{
    case WIN;
    case DRAW;
    case LOSE;

    public static function getByKey(string $key): self
    {
        return match ($key) {
            'X' => self::LOSE,
            'Y' => self::DRAW,
            'Z' => self::WIN,
            default => throw new Exception("False key given"),
        };
    }
}
