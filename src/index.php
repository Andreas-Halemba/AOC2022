<?php

include('./vendor/autoload.php');

use App\day2\Day2;
use App\day3\Day3;
use App\day4\Day4;
use App\day5\Day5;

use function App\day2\playDay2;
use function App\day3\playDay3;

match ($argv[1]) {
    'day2' => new Day2(),
    'day3' => new Day3(),
    'day4' => new Day4(),
    'day5' => new Day5(),
    default => print_r("wrong day given")
};
