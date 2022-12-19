<?php

namespace App\day3;

class Day3
{
    private string $fileName = './src/day3/input.txt';

    public function __construct()
    {
    }

    public function solve()
    {
        return [
            array_sum($this->partOne()),
            array_sum($this->partTwo()),
        ];
    }

    public function partOne(): array
    {
        $result = [];
        $lines = file($this->fileName);
        foreach ($lines as $lineCount => $line) {
            $containerLength = strlen(trim($line)) / 2;
            $containers = str_split(trim($line), $containerLength);
            foreach (str_split($containers[0]) as $char) {
                if ($pos = strpos($containers[1], $char) !== false) {
                    $containers['chars'][] = [$char, $pos];
                    $result[$lineCount] = $this->addCharPrio($char);
                }
            }
        }
        return $result;
    }

    public function partTwo(): array
    {
        $lines = file($this->fileName);
        $badges = array_chunk($lines, 3);
        $foundChars = [];
        foreach ($badges as $badgeKey => $badge) {
            foreach ($badge as $key => $rucksack) {
                if ($key !== 0) {
                    continue;
                }
                foreach (str_split(trim($rucksack)) as $char) {
                    if (strpos($badge[1], $char) !== false) {
                        if (strpos($badge[2], $char) !== false) {
                            $foundChars[$badgeKey] = $this->addCharPrio($char);
                            break;
                        }
                    }
                }
            }
        }
        return $foundChars;
    }

    public function addCharPrio(string $char): int
    {
        $charsWithPrio = [];
        foreach (range('a', 'z') as $key => $character) {
            $charsWithPrio[$character] = $key + 1;
        }
        foreach (range('A', 'Z') as $key => $character) {
            $charsWithPrio[$character] = ($key + 27);
        }
        return $charsWithPrio[$char];
    }
}
