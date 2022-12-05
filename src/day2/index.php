<?php

namespace App {

    use App\Pick as PickEnum;
    use App\Result as ResultEnum;
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

    function getPick(string $pick): int
    {
        return match ($pick) {
            'A', 'X' => 1,
            'B', 'Y' => 2,
            'C', 'Z' => 3,
            default => throw new Exception("False pick given"),
        };
    }

    function rockPickResult(int $oponentPick): int
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

    function paperPickResult(int $oponentPick): int
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

    function sissorsPickResult(int $oponentPick): int
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

    function main(): void
    {
        if (($input = fopen('./src/day2/partOne.txt', 'r'))) {
            $totalPoints = 0;
            while (($line = fgets($input))) {
                $picks = array_filter(preg_split('/\s+/', $line));
                $totalPoints += match (getPick($picks[1])) {
                    1 => rockPickResult(getPick($picks[0])),
                    2 => paperPickResult(getPick($picks[0])),
                    3 => sissorsPickResult(getPick($picks[0])),
                    default => throw new Exception("Invalid data given"),
                };
            }
            echo "\nTotal points: " . $totalPoints;
        }
    }

    /** returns the points i would get for the pick that loses me the round */
    function lose(string $oponentPick): int
    {
        return match ($oponentPick) {
            'A' => 3,
            'B' => 1,
            'C' => 2,
            default => throw new Exception("Invalid data given"),
        };
    }

    /** returns the points i would get for the pick that draws me the round */
    function draw(string $oponentPick): int
    {
        return match ($oponentPick) {
            'A' => 1,
            'B' => 2,
            'C' => 3,
            default => throw new Exception("Invalid data given"),
        };
    }

    function win(string $oponentPick): int
    {
        return match ($oponentPick) {
            'A' => 2,
            'B' => 3,
            'C' => 1,
            default => throw new Exception("Invalid data given"),
        };
    }

    function pointsByResult(string $result): int
    {
        return match ($result) {
            'X' => 0,
            'Y' => 3,
            'Z' => 6,
            default => throw new Exception("Invalid data given"),
        };
    }

    function getPlayerPick(string $expectedResult, string $oponentPick): int
    {
        return match ($expectedResult) {
            'X' => lose($oponentPick),
            'Y' => draw($oponentPick),
            'Z' => win($oponentPick),
            default => throw new Exception("Invalid data given"),
        };
    }

    function roundTwo(): void
    {
        $totalPoints = 0;
        if (($input = fopen('./src/day2/partTwo.txt', 'r'))) {
            while (($line = fgets($input))) {
                $picks = array_filter(preg_split('/\s+/', $line));
                $oponentPick = $picks[0];
                $playerPickPionts = getPlayerPick($picks[1], $oponentPick);
                $resultPoints = pointsByResult($picks[1]);
                $totalPoints += ($resultPoints + $playerPickPionts);
            }
        }
        var_dump([
            'totalPoints' => $totalPoints,
        ]);
    }

    // main();
    roundTwo();
};
