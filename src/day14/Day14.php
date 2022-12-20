<?php

namespace App\day14;

class Day14
{
    private array $grid = [];
    private array $input;
    public function __construct($mode)
    {
        $this->input = match ($mode) {
            'test' => file(__DIR__ . DIRECTORY_SEPARATOR . $mode . '.txt', 2),
            default => file(__DIR__ . DIRECTORY_SEPARATOR . 'input.txt', 2)
        };
    }

    public function solve()
    {
        return [
            $this->part1(),
            $this->part2()
        ];
    }

    public function part1()
    {
        $maxX = 0;
        $minX = 100000;
        $maxY = 0;
        $minY = 100000;
        array_walk($this->input, function ($line) use (&$maxX, &$minX, &$maxY, &$minY) {
            $cords = explode(' -> ', trim($line));
            foreach ($cords as $key => $cord) {
                if ($key === array_key_last($cords)) {
                    continue;
                }
                [$x, $y] = explode(',', $cord);
                [$nx, $ny] = explode(',', $cords[$key + 1]);
                if ($nx === 0) {
                    continue;
                }
                if ($x == $nx) {
                    if ($y > $ny) {
                        $maxY = max($maxY, $y);
                        $minY = min($minY, $ny);
                    } else {
                        $maxY = max($maxY, $ny);
                        $minY = min($minY, $y);
                    }
                } elseif ($y == $ny) {
                    if ($x > $nx) {
                        $maxX = max($maxX, $x);
                        $minX = min($minX, $nx);
                    } else {
                        $maxX = max($maxX, $nx);
                        $minX = min($minX, $x);
                    }
                }
            }
        });
        $emptyGrid = array_fill(0, $maxY + 2, array_fill($minX - $maxY, ($maxX  - $minX) + $maxY + 100, '.'));
        $emptyGrid[0][500] = '+';
        $emptyGrid[$maxY + 2] =  array_fill($minX - $maxY, ($maxX  - $minX) + $maxY + 100, '#');
        foreach ($this->input as $line) {
            $cords = explode(' -> ', trim($line));
            foreach ($cords as $key => $cord) {
                if (array_key_exists($key + 1, $cords)) {
                    [$x, $y] = explode(',', $cord);
                    [$nx, $ny] = explode(',', $cords[$key + 1]);
                    if ($x === $nx) {
                        if ($y > $ny) {
                            for ($i = $ny; $i <= $y; $i++) {
                                $emptyGrid[$i][$x] = '#';
                            }
                        } else {
                            for ($i = $y; $i <= $ny; $i++) {
                                $emptyGrid[$i][$x] = '#';
                            }
                        }
                    }
                    if ($y === $ny) {
                        if ($x > $nx) {
                            for ($i = $nx; $i <= $x; $i++) {
                                $emptyGrid[$y][$i] = '#';
                            }
                        } else {
                            for ($i = $x; $i <= $nx; $i++) {
                                $emptyGrid[$y][$i] = '#';
                            }
                        }
                    }
                } else {
                    continue;
                }
            }
        }

        $sandposition = [0, 500];
        $counter = 0;
        while (true) {
            $counter++;
            if ($sandposition[0] === 0 && $counter >= 10000000) {
                break;
            };
            if ($emptyGrid[$sandposition[0] + 1][$sandposition[1]] === '.') {
                $sandposition[0]++;
                continue;
            } elseif (
                $emptyGrid[$sandposition[0] + 1][$sandposition[1]] !== '.'
                && $emptyGrid[$sandposition[0] + 1][$sandposition[1] - 1] === '.'
            ) {
                $sandposition[0]++;
                $sandposition[1]--;
                continue;
            } elseif (
                $emptyGrid[$sandposition[0] + 1][$sandposition[1]] !== '.'
                && $emptyGrid[$sandposition[0] + 1][$sandposition[1] - 1] !== '.'
                && $emptyGrid[$sandposition[0] + 1][$sandposition[1] + 1] === '.'
            ) {
                $sandposition[0]++;
                $sandposition[1]++;
                continue;
            } else {
                $emptyGrid[$sandposition[0]][$sandposition[1]] = 'o';
                $sandposition = [0, 500];
                continue;
            }
        }
        // $this->drawGrid($emptyGrid);
        $counter = 0;
        array_walk_recursive($emptyGrid, function ($item) use (&$counter) {
            if ($item === 'o') {
                $counter++;
            }
        });
        var_dump($counter);
    }


    public function drawGrid($grid)
    {
        foreach ($grid as $x => $y) {
            echo ($x . ">\t" . join('', $y));
            echo PHP_EOL;
        }
    }

    public function part2()
    {
        return 0;
    }
}
