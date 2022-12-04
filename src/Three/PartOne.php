<?php

include_once('./src/Three/helper.php');

function partOne()
{
    var_dump(array_sum(readInput('handleLinePartOne')));
}

function handleLinePartOne(&$result, string $line, int $lineCount)
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
