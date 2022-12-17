<?php

namespace App\day15;

include('./vendor/autoload.php');

(new Day15($argv[1] ?? null))->solve($argv[2] ?? 1);
