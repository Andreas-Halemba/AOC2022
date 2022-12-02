<?php

namespace App {

    use App\Pick as PickEnum;
    use App\Result as ResultEnum;

    use function PHPSTORM_META\map;

    enum Pick
    {
        case ROCK;
        case PAPER;
        case SISSORS;

        public static function getByKey($key): self
        {
            return match ($key) {
                'A' => self::ROCK,
                'B' => self::PAPER,
                'C' => self::SISSORS,
            };
        }

        public static function getByPoints($points): self
        {
            return match ($points) {
                1 => self::ROCK,
                2 => self::PAPER,
                3 => self::SISSORS,
            };
        }
    }

    enum Result
    {
        case WIN;
        case DRAW;
        case LOSE;

        public static function getByKey($key): self
        {
            return match ($key) {
                'X' => self::LOSE,
                'Y' => self::DRAW,
                'Z' => self::WIN,
            };
        }
    }

    function getPick($pick): int
    {
        return match ($pick) {
            'A', 'X' => 1,
            'B', 'Y' => 2,
            'C', 'Z' => 3,
        };
    }

    function rockPickResult($oponentPick): int
    {
        $pickPoints = 1;
        $resultPoints = match ($oponentPick) {
            1 =>  3,
            2 =>  0,
            3 =>  6,
        };
        return $pickPoints + $resultPoints;
    }

    function paperPickResult($oponentPick): int
    {
        $pickPoints = 2;
        $resultPoints = match ($oponentPick) {
            1 =>  6,
            2 =>  3,
            3 =>  0,
        };
        return $pickPoints + $resultPoints;
    }

    function sissorsPickResult($oponentPick): int
    {
        $pickPoints = 3;
        $resultPoints = match ($oponentPick) {
            1 =>  0,
            2 =>  6,
            3 =>  3,
        };
        return $pickPoints + $resultPoints;
    }

    function main(): void
    {
        if (($input = fopen('./src/2/partOne.txt', 'r'))) {
            $totalPoints = 0;
            while (($line = fgets($input))) {
                $picks = array_filter(preg_split('/\s+/', $line));
                $totalPoints += match (getPick($picks[1])) {
                    1 => rockPickResult(getPick($picks[0])),
                    2 => paperPickResult(getPick($picks[0])),
                    3 => sissorsPickResult(getPick($picks[0])),
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
        };
    }

    /** returns the points i would get for the pick that draws me the round */
    function draw(string $oponentPick)
    {
        return match ($oponentPick) {
            'A' => 1,
            'B' => 2,
            'C' => 3,
        };
    }

    function win(string $oponentPick)
    {
        return match ($oponentPick) {
            'A' => 2,
            'B' => 3,
            'C' => 1,
        };
    }

    function pointsByResult(string $result): int
    {
        return match ($result) {
            'X' => 0,
            'Y' => 3,
            'Z' => 6,
        };
    }

    function getPlayerPick(string $expectedResult, string $oponentPick): int
    {
        return match ($expectedResult) {
            'X' => lose($oponentPick),
            'Y' => draw($oponentPick),
            'Z' => win($oponentPick),
        };
    }

    function roundTwo(): void
    {
        $totalPoints = 0;
        if (($input = fopen('./src/2/partTwo.txt', 'r'))) {
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
