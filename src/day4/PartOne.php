<?php

namespace App\day4;

use App\GlobalHelpers;

class PartOne extends GlobalHelpers
{

    public int $result = 0;

    public function __construct()
    {
        self::readInput('handleLinePartOne', 'day4');
        var_dump($this->result);
    }

    public function handleLinePartOne(string $line, int $lineCount): void
    {
        $cleanLine = trim($line);
        $chunks = explode(',', $cleanLine);
        foreach ($chunks as $key => $chunk) {
            $range = explode('-', $chunk);
            $groups[$key] = $range;
        }
        $groupA = $groups[0];
        $groupB = $groups[1];
        if ($groupA[0] <= $groupB[0] && $groupA[1] >= $groupB[1]) {
            $this->result++;
        } elseif ($groupA[0] >= $groupB[0] && $groupA[1] <= $groupB[1]) {
            $this->result++;
        }
    }
}
