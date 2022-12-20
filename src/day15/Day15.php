<?php

namespace App\day15;

use App\GlobalHelpers;

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
        $grid = $this->getSensorGrid(true);
        $res = $this->part1($grid);
        // $this->drawGrid($grid);
        GlobalHelpers::nl("solution part 1 = " . $res);
        $grid = $this->getSensorGrid(false);
        $res = $this->part2($grid);
        GlobalHelpers::nl("solution part 2 = " . $res);
    }

    public function part1($grid)
    {
        $result = $this->getRangesOfLine($grid, $this->finalLine)[0];
        var_dump($result);
        return $result[1] - $result[0];
    }

    public function part2($grid)
    {
        for ($i = 0; $i < 4000000; $i++) {
            if (count($res = $this->getRangesOfLine($grid, $i)) > 1) {
                return ($res[0][1] + 1) * 4000000 + $i;
            }
        }
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
                $this->minY = min($miny);
                $this->maxY = max($maxy);
                $this->minX = min($minx);
                $this->maxX = max($maxx);
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
            if ($rest < 0) {
                continue;
            }
            $ranges[] = [$x - $rest, $x + $rest];
        }
        asort($ranges);
        // GlobalHelpers::nl("line $line");
        $ranges = array_values($ranges);
        $consolidate = [];
        [$start, $end] = $ranges[0];
        for ($i = 1; $i < count($ranges); $i++) {
            if ($end >= $ranges[$i][0]) {
                $end = max($end, $ranges[$i][1]);
            } else {
                $consolidate[] = [$start, $end];
                [$start, $end] = $ranges[$i];
            }
        }
        if (!in_array([$start, $end], $consolidate)) {
            $consolidate[] = [$start, $end];
        }
        return $consolidate;
    }

    public function drawGrid($grid)
    {
        $paintPlane = array_fill(
            $this->minY,
            $this->maxY - $this->minY + 2,
            array_fill(
                $this->minX,
                $this->maxX - $this->minX + 2,
                '.'
            )
        );
        foreach ($grid as $sensor) {
            $paintPlane[$sensor['y']][$sensor['x']] = 'S';
            $paintPlane[$sensor['by']][$sensor['bx']] = 'B';
            foreach ($paintPlane as $lineNumber => $paintLine) {
                $width = $sensor['d'] - abs($lineNumber - $sensor['y']);
                if ($width < 0) {
                    continue;
                }
                if ($width === 0) {
                    $paintPlane[$lineNumber][$sensor['x']] = '#';
                    continue;
                }
                for ($i = $sensor['x'] - $width; $i < $sensor['x'] + $width + 1; $i++) {
                    $paintPlane[$lineNumber][$i] =
                        $paintPlane[$lineNumber][$i] === '.' ? '#' : $paintPlane[$lineNumber][$i];
                }
            }
        }
        foreach ($paintPlane as $y => $line) {
            ksort($line);
            GlobalHelpers::nl($y . ">\t" . implode('', $line));
        }
    }
}
