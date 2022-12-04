<?php

use App\GlobalHelpers;

include_once('./src/day3/helper.php');

function handleLinePartTwo(&$result, string $line, int $lineCount)
{
    $result[] = trim($line);
}

function partTwo()
{
    $lines = readInput('handleLinePartTwo');

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
                        $foundChars[$badgeKey] = addCharPrio($char);
                        break;
                    }
                }
            }
        }
    }
    var_dump(array_sum($foundChars));
}
