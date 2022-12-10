<?php

namespace App\day8;

class Day8
{
    private array $treeMap;

    public int $visibleTrees = 0;

    public array $scenicScores = [];

    public function __construct()
    {
        $lines = file(__DIR__ . "/input.txt", 2);
        $this->treeMap = array_map(fn ($line) => str_split($line), $lines);
        array_walk($this->treeMap, fn ($items, $index) => $this->walkTrees($items, $index, 0));
        var_dump($this->visibleTrees);
        var_dump(max($this->scenicScores));
    }

    public function walkTrees($tree, $index, $row)
    {
        if (is_string($tree)) {
            $columnTrees = array_column($this->treeMap, $index);
            $treesLeft = array_slice($this->treeMap[$row], 0, $index);
            $treesRight = array_slice($this->treeMap[$row], $index + 1);
            $treesAbove = array_slice($columnTrees, 0, $row);
            $treesBelow = array_slice($columnTrees, $row + 1);

            $outerOne = match (true) {
                count($treesLeft) === 0,
                count($treesRight) === 0,
                count($treesAbove) === 0,
                count($treesBelow) === 0 => true,
                default => false,
            };
            if ($outerOne) {
                $this->visibleTrees += 1;
            } else {
                $innerVisible = match (true) {
                    count(array_filter($treesLeft, fn ($item) => $item >= $tree)) === 0,
                    count(array_filter($treesRight, fn ($item) => $item >= $tree)) === 0,
                    count(array_filter($treesAbove, fn ($item) => $item >= $tree)) === 0,
                    count(array_filter($treesBelow, fn ($item) => $item >= $tree)) === 0 => true,
                    default => false,
                };
                if ($innerVisible) {
                    $this->visibleTrees += 1;
                    $treesAround = [
                        'left' => array_reverse($treesLeft),
                        'right' => $treesRight,
                        'above' => array_reverse($treesAbove),
                        'below' => $treesBelow,
                    ];
                    $views = [];
                    foreach ($treesAround as $direction => $nextTreeDirection) {
                        foreach ($nextTreeDirection as $distance => $treeHeight) {
                            if ($treeHeight < $tree) {
                                $views[$direction] = $distance + 1;
                            }
                            if ($treeHeight >= $tree) {
                                $views[$direction] = $distance + 1;
                                break;
                            }
                        }
                    }
                    $this->scenicScores[] = array_product($views);
                }
            }
        }
        if (is_array($tree)) {
            array_walk($tree, fn ($items, $itemIndex) => $this->walkTrees($items, $itemIndex, $index));
        }
    }
}
