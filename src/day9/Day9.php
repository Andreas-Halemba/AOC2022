<?php

namespace App\day9;

use Exception;

class Day9
{
    private array $moves;
    private array $headMap = [0 => [0 => 's']];
    private array $tailMap;
    private int $currentRow = 0;
    private int $currentCol = 0;
    private int $minCol = 0;
    private int $maxCol = 0;
    private array $headPosition = ['x' => 0, 'y' => 0];
    private array $tailPosition;
    private array $total = [0, 0];
    private int $currentTail = 0;
    private int $movecounter = 0;

    public function __construct(private string $mode = 'input')
    {
        foreach (range(0, 8) as $tailNumber) {
            $this->tailPosition[$tailNumber] = ['x' => 0, 'y' => 0];
            $this->tailMap[$tailNumber] = [[0 => 's']];
            $this->tailMap[$tailNumber] = [[0 => 's']];
        }
        $this->moves = array_map(
            fn ($line) => explode(' ', $line),
            file(__DIR__ . DIRECTORY_SEPARATOR . $mode . '.txt', 2)
        );
        array_walk($this->moves, function ($move, $index) {
            for ($steps = 0; $steps < $move[1]; $steps++) {
                $this->movecounter++;
                $this->moveHead($move[0]);
                foreach ($this->tailPosition as $tailnumber => $tail) {
                    $this->currentTail = $tailnumber;
                    $this->calcHeadTailDistance();
                    if ($tailnumber === 2) {
                        $this->printMap($this->tailMap[$tailnumber]);
                    }
                }
            }
        });
        array_walk_recursive($this->tailMap[0], fn ($value) => $this->total[0]++);
        array_walk_recursive($this->tailMap[8], fn ($value) => $this->total[1]++);
        var_dumP($this->total);
    }

    public function printMap($map)
    {
        ksort($map);
        foreach (array_reverse($map) as $columns) {
            $mapRow = array_fill($this->minCol, (abs($this->minCol) + $this->maxCol) + 1, '.');
            foreach ($columns as $index => $icon) {
                $mapRow[$index] = $icon;
            }
            ksort($mapRow);
            echo join('', $mapRow) . PHP_EOL;
        }
    }

    public function setHeadPosition($row, $col): void
    {
        $this->currentRow = $row;
        $this->currentCol = $col;
        $this->headPosition = ['y' => $row, 'x' => $col];
        if ($this->maxCol < $col) {
            $this->maxCol = $col;
        }
        if ($this->minCol > $col) {
            $this->minCol = $col;
        }
    }

    public function moveHead(string $move): void
    {
        match ($move) {
            'R' => $this->setHeadPosition($this->currentRow, $this->currentCol + 1),
            'L' => $this->setHeadPosition($this->currentRow, $this->currentCol - 1),
            'U' => $this->setHeadPosition($this->currentRow + 1, $this->currentCol),
            'D' => $this->setHeadPosition($this->currentRow - 1, $this->currentCol),
        };
        $this->headMap[$this->currentRow][$this->currentCol] = 'H';
        $this->headPosition = ['y' => $this->currentRow, 'x' => $this->currentCol];
    }

    public function calcHeadTailDistance()
    {
        if ($this->areTouching()) {
            return;
        }
        $this->directionToMoveTail();

        $this->tailMap[$this->currentTail][$this->tailPosition[$this->currentTail]['y']][$this->tailPosition[$this->currentTail]['x']] = 'T';
    }

    public function areTouching()
    {
        if ($this->currentTail > 0) {
            return abs($this->tailPosition[$this->currentTail - 1]['x'] - $this->tailPosition[$this->currentTail]['x']) <= 1 && abs($this->tailPosition[$this->currentTail - 1]['y'] - $this->tailPosition[$this->currentTail]['y']) <= 1;
        } else {
            return abs($this->headPosition['x'] - $this->tailPosition[$this->currentTail]['x']) <= 1 && abs($this->headPosition['y'] - $this->tailPosition[$this->currentTail]['y']) <= 1;
        }
    }

    public function directionToMoveTail()
    {
        ['x' => $hx, 'y' => $hy] = $this->headPosition;
        if ($this->currentTail > 0) {
            ['x' => $hx, 'y' => $hy] = $this->tailPosition[$this->currentTail - 1];
        }
        ['x' => $tx, 'y' =>  $ty] = $this->tailPosition[$this->currentTail];
        match (true) {
            $hx - 2 === $tx && $hy === $ty => $this->moveRight(),
            $hx + 2 === $tx && $hy === $ty => $this->moveLeft(),
            $hy - 2 === $ty && $hx === $tx => $this->moveUp(),
            $hy + 2 === $ty && $hx === $tx => $this->moveDown(),
            $hx - $tx === 2 && $hy - $ty === 2,
            $hx - $tx === 2 && $hy - $ty === 1,
            $hx - 1 === $tx && $hy - 1 > $ty => $this->moveUpRight(),
            $hx - $tx === -2 && $hy - $ty === 2,
            $hx - $tx === -2 && $hy - $ty === 1,
            $hx - $tx === -1 && $hy - $ty === 2 => $this->moveUpLeft(),
            $hx - $tx === 2 && $hy - $ty === -2,
            $hx - $tx === 1 && $hy - $ty === -2,
            $hx - $tx === 2 && $hy - $ty === -1 => $this->moveDownRight(),
            $hx - $tx === -1 && $hy - $ty === -2,
            $hx - $tx === -2 && $hy - $ty === -2,
            $hx - $tx === -2 && $hy - $ty === -1 => $this->moveDownLeft(),
            default => $this->a(),
        };
    }

    public function a($condition = null)
    {
        ['x' => $hx, 'y' => $hy] = $this->headPosition;
        if ($this->currentTail > 0) {
            ['x' => $hx, 'y' => $hy] = $this->tailPosition[$this->currentTail - 1];
        }
        ['x' => $tx, 'y' =>  $ty] = $this->tailPosition[$this->currentTail];
        print_r([$hx - $tx, $hy - $ty]);
        throw new Exception("direction unclear X $hx::$tx => Y $hy::$ty");
    }

    public function moveDownRight()
    {
        $this->moveDown();
        $this->moveRight();
    }
    public function moveDownLeft()
    {
        $this->moveDown();
        $this->moveLeft();
    }
    public function moveUpRight()
    {
        $this->moveUp();
        $this->moveRight();
    }
    public function moveUpLeft()
    {
        $this->moveUp();
        $this->moveLeft();
    }

    public function setTailPosition($x, $y, $tail = 0)
    {
        $this->tailPosition[$this->currentTail] = ['x' => $x, 'y' => $y];
    }

    public function moveRight()
    {
        $this->setTailPosition(
            x: $this->tailPosition[$this->currentTail]['x'] + 1,
            y: $this->tailPosition[$this->currentTail]['y']
        );
    }
    public function moveLeft()
    {
        $this->setTailPosition(
            x: $this->tailPosition[$this->currentTail]['x'] - 1,
            y: $this->tailPosition[$this->currentTail]['y']
        );
    }

    public function moveDown()
    {
        $this->setTailPosition(
            x: $this->tailPosition[$this->currentTail]['x'],
            y: $this->tailPosition[$this->currentTail]['y'] - 1
        );
    }
    public function moveUp()
    {
        $this->setTailPosition(
            x: $this->tailPosition[$this->currentTail]['x'],
            y: $this->tailPosition[$this->currentTail]['y'] + 1
        );
    }

    public function printTailMap()
    {
        $flippedMap = $this->tailMap;
        $flippedMap = array_reverse($this->tailMap);
        foreach ($flippedMap as $columns) {
            ksort($columns);
            for ($i = 0; $i <= $this->maxCol; $i++) {
                if (!array_key_exists($i, $columns)) {
                    $columns[$i] = '.';
                } else {
                }
                echo $columns[$i];
            }
            echo "\n";
        }
    }
}
