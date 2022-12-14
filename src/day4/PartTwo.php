<?php

namespace App\day4;

use App\GlobalHelpers;

class PartTwo extends GlobalHelpers
{
    public int $result = 0;

    public function __construct()
    {
        // $this->readTestInput('handleLinePartOne', 'day4');
        $this->readInput('handleLinePartOne', 'day4');
    }

    public function getResult(): int
    {
        return $this->result;
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
        $firstRange = range($groupA[0], $groupA[1]);
        $secondRange = range($groupB[0], $groupB[1]);
        foreach ($firstRange as $number) {
            if (array_search($number, $secondRange) !== false) {
                $this->result++;
                return;
            }
        }
    }
}
