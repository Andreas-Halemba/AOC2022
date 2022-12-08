<?php

/** read file input.txt line by line and split the line into an array by the x character
 * calculate the surface area of the box and add it to the total.
 * calculate the smallest side of the box and add it to the total.
 * return the total.
 */
function readInput(): int
{
    $total  =  0;
    if (($input  =  fopen('./src/2015/day2/input.txt', 'r'))) {
        while (($line  =  fgets($input))) {
            $line  =  explode('x', $line);
            $total  +=  (2  *  $line[0] * $line[1]) + (2  *  $line[1] * $line[2]) + (2  *  $line[2] * $line[0]);
            $total  +=  min($line[0] * $line[1], $line[1] * $line[2], $line[2] * $line[0]);
        }
        return   $total;
    }
    return   0;
}

var_dump(readInput());

/**
 * read file input.txt line by line and split the line into an array by the x character
 * calculate the ribbon length of the box and add it to the total.
 */
function readInput2(): int
{
    $total  =  0;
    if (($input  =  fopen('./src/2015/day2/input.txt', 'r'))) {
        while (($line  =  fgets($input))) {
            $line  =  explode('x', $line);
            $total  +=  (2  *  min($line[0] + $line[1], $line[1] + $line[2], $line[2] + $line[0]));
            $total  +=  $line[0] * $line[1] * $line[2];
        }
        return   $total;
    }
    return   0;
}
var_dump(readInput2());
