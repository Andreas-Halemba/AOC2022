<?php

include('./vendor/autoload.php');

use App\day2\Day2;
use App\day3\Day3;
use App\day4\Day4;
use App\day5\Day5;
use App\day6\Day6;
use App\day7\Day7;
use App\day8\Day8;
use App\day9\Day9;
use App\day10\Day10;
use App\day11\Day11;

match ($argv[1]) {
    'day2' => new Day2(),
    'day3' => new Day3(),
    'day4' => new Day4(),
    'day5' => new Day5(),
    'day6' => new Day6($argv[2]),
    'day7' => new Day7($argv[2] ?? null),
    'day8' => new Day8(),
    'day9' => new Day9($argv[2]),
    'day10' => new Day10($argv[2] ?? null),
    'day11' => new Day11($argv[2] ?? 'test'),
    default => print_r("wrong day given")
};
