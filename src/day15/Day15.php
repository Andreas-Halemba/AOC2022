<?php

namespace App\day15;

function nl(string $string): void
{
    print_r($string . PHP_EOL);
}

class Day15
{
    private array $data = [];
    private int $maxX;
    private int $maxY;
    private int $minY;
    private int $minX;
    private int $finalLine;

    public function __construct(private string $mode = 'test')
    {
        $file  = file(__DIR__ . DIRECTORY_SEPARATOR . $this->mode . '.txt', FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES);
        $this->data = array_map(function ($line) {
            $pattern = "/x\=([-]*\d*),\sy\=([-]*\d*).*x\=([-]*\d*),\sy\=([-]*\d*)/";
            preg_match($pattern, $line, $matches);
            [$_, $sx, $sy, $bx, $by] = $matches;
            return ['S' => ['x' => $sx,  'y' => $sy], 'B' => ['x' => $bx,  'y' => $by]];
        }, $file);
        if ($this->mode === "test") {
            $this->maxY = $this->maxX = 20;
            $this->minY = $this->minX = 0;
            $this->finalLine = 10;
        } else {
            $this->maxY = $this->maxX = 4000000;
            $this->minY = $this->minX = 0;
            $this->finalLine = 2000000;
        }
    }

    public function solve()
    {
        $range = $this->part1();
        nl("solution part 1 = " . $range);
        for ($i = 0; $i < $this->maxX; $i++) {
            $range = $this->getRangesOfLine($this->getSensorGrid(), $i);
        }
    }

    public function part1()
    {
        /** min max geht so leider nicht ich brauch die range mit allen
         *  min max und unterbrechnungen. Die overlaps müssen hier gecheckt werden.
         */
        return $this->getRangesOfLine($this->getSensorGrid(true), $this->finalLine);
    }

    public function getSensorGrid(bool $setMinMax = false): array
    {
        foreach ($this->data as $coords) {
            ['S' => ['x' => $sx, 'y' => $sy], 'B' => ['x' => $bx, 'y' => $by]] = $coords;
            $distance = abs($sx - $bx) + abs($sy - $by);
            $sensorGrid[] = [
                'd' => $distance,
                'x' => $sx,
                'y' => $sy,
                'bx' => $bx,
                'by' => $by,
            ];
            if ($setMinMax) {
                $minx[] = $sx - $distance;
                $maxx[] = $sx + $distance;
                $miny[] = $sy - $distance;
                $maxy[] = $sy + $distance;
            }
        }
        return $sensorGrid;
    }

    public function getRangesOfLine($sensors, $line): int|array
    {
        foreach ($sensors as $sensor) {
            [
                'd' => $d,
                'x' => $x,
                'y' => $y,
            ] = $sensor;
            $rest = $d - abs($line - $y);
            if ($rest <= 0) {
                continue;
            }
            $ranges[] = [$x - $rest, $x + $rest,];
        }
        if (!isset($ranges)) {
            return false;
        }
        asort($ranges);
        $min = $this->maxY;
        $max = $this->minY;
        foreach ($ranges as $key => $range) {
            $min = ($range[0] < $min) ? $range[0] : $min;
            $max = ($range[1] > $max) ? $range[1] : $max;
        }
        return $max - $min;
    }
}
