<?php

namespace App\day2\Emuns;

use Exception;

enum Pick
{
    case ROCK;
    case PAPER;
    case SISSORS;

    public static function getByKey(string $key): self
    {
        return match ($key) {
            'A' => self::ROCK,
            'B' => self::PAPER,
            'C' => self::SISSORS,
            default => throw new Exception("False key given"),
        };
    }

    public static function getByPoints(int $points): self
    {
        return match ($points) {
            1 => self::ROCK,
            2 => self::PAPER,
            3 => self::SISSORS,
            default => throw new Exception("False points given"),
        };
    }
}
