<?php

namespace App\day3;

class PartOne
{
    public function partOne(): void
    {
        var_dump(array_sum(readInput('handleLinePartOne')));
    }

    /**
     * @param array<int> $result
     * @param string $line
     * @param integer $lineCount
     * @return void
     */
    protected function handleLinePartOne(array &$result, string $line, int $lineCount): void
    {
        $containerLength = strlen(trim($line)) / 2;
        $containers = str_split(trim($line), $containerLength);
        foreach (str_split($containers[0]) as $key => $char) {
            if ($pos = strpos($containers[1], $char) !== false) {
                $containers['chars'][] = [$char, $pos];
                $result[$lineCount] = addCharPrio($char);
            }
        }
    }
}
