<?php

/** read file input.txt line character by character
 * if the character is ( add 1 to the sum if the character is ) subtract 1 from the sum
 */
function readInput(): int
{
    $sum = 0;
    if (($input = fopen('./src/2015/day1/input.txt', 'r'))) {
        while (($line = fgets($input))) {
            $line = str_split($line);
            foreach ($line as $char) {
                if ($char === '(') {
                    $sum++;
                } elseif ($char === ')') {
                    $sum--;
                }
            }
        }
        return $sum;
    }
    return 0;
}
var_dump(readInput());

/** read file input.txt line character by character
 * if the character is ( add 1 to the sum if the character is ) subtract 1 from the sum
 * if the sum is -1 return the position of the character
 */
function readInput2(): int
{
    $sum = 0;
    if (($input = fopen('./src/2015/day1/input.txt', 'r'))) {
        $lineCount = 0;
        while (($line = fgets($input))) {
            $line = str_split($line);
            foreach ($line as $char) {
                $lineCount++;
                if ($char === '(') {
                    $sum++;
                } elseif ($char === ')') {
                    $sum--;
                }
                if ($sum === -1) {
                    return $lineCount;
                }
            }
        }
        return $sum;
    }
    return 0;
}
var_dump(readInput2());
