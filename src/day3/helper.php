<?php

function readInput($lineHandler): array
{
    if (($input = fopen('./src/day3/input.txt', 'r'))) {
        $result = [];
        $lineCount = 0;
        while (($line = fgets($input))) {
            $lineCount++;
            $lineHandler($result, $line, $lineCount);
        }
        return $result;
    }
    return [];
}

function addCharPrio(string $char): int
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
