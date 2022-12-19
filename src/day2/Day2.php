<?php

namespace App\day2;

use Exception;

class Day2
{
    public function __construct()
    {
    }

    public function solve()
    {
        return [
            $this->roundOne(),
            $this->roundTwo()
        ];
    }

    private function getPick(string $pick): int
    {
        return match ($pick) {
            'A', 'X' => 1,
            'B', 'Y' => 2,
            'C', 'Z' => 3,
            default => throw new Exception("False pick given"),
        };
    }

    private function rockPickResult(int $oponentPick): int
    {
        $pickPoints = 1;
        $resultPoints = match ($oponentPick) {
            1 =>  3,
            2 =>  0,
            3 =>  6,
            default => throw new Exception("Invalid data given"),
        };
        return $pickPoints + $resultPoints;
    }

    private function paperPickResult(int $oponentPick): int
    {
        $pickPoints = 2;
        $resultPoints = match ($oponentPick) {
            1 =>  6,
            2 =>  3,
            3 =>  0,
            default => throw new Exception("Invalid data given"),
        };
        return $pickPoints + $resultPoints;
    }

    private function sissorsPickResult(int $oponentPick): int
    {
        $pickPoints = 3;
        $resultPoints = match ($oponentPick) {
            1 =>  0,
            2 =>  6,
            3 =>  3,
            default => throw new Exception("Invalid data given"),
        };
        return $pickPoints + $resultPoints;
    }

    /** returns the points i would get for the pick that loses me the round */
    private function lose(string $oponentPick): int
    {
        return match ($oponentPick) {
            'A' => 3,
            'B' => 1,
            'C' => 2,
            default => throw new Exception("Invalid data given"),
        };
    }

    /** returns the points i would get for the pick that draws me the round */
    private function draw(string $oponentPick): int
    {
        return match ($oponentPick) {
            'A' => 1,
            'B' => 2,
            'C' => 3,
            default => throw new Exception("Invalid data given"),
        };
    }

    private function win(string $oponentPick): int
    {
        return match ($oponentPick) {
            'A' => 2,
            'B' => 3,
            'C' => 1,
            default => throw new Exception("Invalid data given"),
        };
    }

    private function pointsByResult(string $result): int
    {
        return match ($result) {
            'X' => 0,
            'Y' => 3,
            'Z' => 6,
            default => throw new Exception("Invalid data given"),
        };
    }

    private function getPlayerPick(string $expectedResult, string $oponentPick): int
    {
        return match ($expectedResult) {
            'X' => $this->lose($oponentPick),
            'Y' => $this->draw($oponentPick),
            'Z' => $this->win($oponentPick),
            default => throw new Exception("Invalid data given"),
        };
    }

    private function roundOne(): int
    {
        if (($input = fopen('./src/day2/partOne.txt', 'r'))) {
            $totalPoints = 0;
            while (($line = fgets($input))) {
                $picks = array_filter(preg_split('/\s+/', $line));
                $totalPoints += match ($this->getPick($picks[1])) {
                    1 => $this->rockPickResult($this->getPick($picks[0])),
                    2 => $this->paperPickResult($this->getPick($picks[0])),
                    3 => $this->sissorsPickResult($this->getPick($picks[0])),
                    default => throw new Exception("Invalid data given"),
                };
            }
            return $totalPoints;
        }
    }

    private function roundTwo(): int
    {
        $totalPoints = 0;
        if (($input = fopen('./src/day2/partTwo.txt', 'r'))) {
            while (($line = fgets($input))) {
                $picks = array_filter(preg_split('/\s+/', $line));
                $oponentPick = $picks[0];
                $playerPickPionts = $this->getPlayerPick($picks[1], $oponentPick);
                $resultPoints = $this->pointsByResult($picks[1]);
                $totalPoints += ($resultPoints + $playerPickPionts);
            }
        }
        return $totalPoints;
    }
}
