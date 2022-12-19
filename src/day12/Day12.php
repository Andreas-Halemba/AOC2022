<?php

namespace App\day12;

use App\GlobalHelpers;

class Day12
{
    private array $lines;

    private array $grid;

    public function __construct($mode = null)
    {
        $this->readfile($mode);
        $this->toGrid();
    }

    public function readFile(string $mode = "test"): void
    {
        $this->lines = file(
            __DIR__ . DIRECTORY_SEPARATOR . $mode . ".txt",
            FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES
        );
    }

    public function toGrid()
    {
        foreach ($this->lines as $line) {
            $this->grid[] = str_split($line);
        }
    }

    public function solve()
    {
        $result = [
            $this->part1(),
            $this->part2(),
        ];
        var_dump($result);
        return $result;
    }

    public function part1()
    {
        [$start, $end] = $this->getStartAndEnd();
        $queue = [[0, $start[0], $start[1]]];
        $visited = [$start];
        while (count($queue) > 0) {
            [$d, $r, $c] = array_shift($queue);
            foreach ($this->getNeighbors($r, $c) as $neighbor) {
                [$nr, $nc] = $neighbor;
                if ((ord($this->grid[$nr][$nc]) - ord($this->grid[$r][$c])) > 1) {
                    continue;
                }
                if ($neighbor === $end) {
                    $this->grid[$end[0]][$end[1]] = 'E';
                    $this->grid[0][0] = 'S';
                    return $d + 1;
                }
                if (array_search($neighbor, $visited)) {
                    continue;
                }
                $visited[] = $neighbor;
                $queue[] = [$d + 1, $nr, $nc];
            }
        }
    }

    public function part2()
    {
        [$start, $end] = $this->getStartAndEnd();
        $queue = [[0, $end[0], $end[1]]];
        $visited = [$end];
        while (count($queue) > 0) {
            [$d, $r, $c] = array_shift($queue);
            foreach ($this->getNeighbors($r, $c) as $neighbor) {
                [$nr, $nc] = $neighbor;
                if ((ord($this->grid[$r][$c]) - ord($this->grid[$nr][$nc])) > 1) {
                    continue;
                }
                if ($nc === 0) {
                    $this->grid[$end[0]][$end[1]] = 'E';
                    $this->grid[0][0] = 'S';
                    return $d + 1;
                }
                if (array_search($neighbor, $visited)) {
                    continue;
                }
                $visited[] = $neighbor;
                $queue[] = [$d + 1, $nr, $nc];
            }
        }
    }

    private function drawGrid($grid)
    {
        for ($r = 0; $r < count($grid); $r++) {
            echo implode('', $grid[$r]) . PHP_EOL;
        }
    }

    public function getNeighbors($r, $c)
    {
        return array_filter([[$r, $c - 1], [$r, $c + 1], [$r - 1, $c], [$r + 1, $c]], function ($item) {
            $nr = $item[0];
            $nc = $item[1];
            return $nr >= 0 && $nc >= 0 && $nr <= array_key_last($this->grid) && $nc <= array_key_last($this->grid[0]);
        });
    }

    public function getStartAndEnd(): array
    {
        $startCoord = [];
        $endCoord = [];
        for ($r = 0; $r < count($this->grid); $r++) {
            for ($c = 0; $c < count($this->grid[$r]); $c++) {
                if ($this->grid[$r][$c] === "S") {
                    $startCoord = [$r, $c];
                    $this->grid[$r][$c] = 'a';
                }
                if ($this->grid[$r][$c] === "E") {
                    $endCoord = [$r, $c];
                    $this->grid[$r][$c] = 'z';
                }
            }
        }
        return [$startCoord, $endCoord];
    }
}
