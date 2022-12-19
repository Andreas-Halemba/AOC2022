<?php

namespace App\day5;

use App\day5\PartOne;

class Day5
{
    public function __construct()
    {
    }

    public function solve()
    {
        return  [
            (new PartOne())->getResult(),
            (new PartOne('two'))->getResult(),
        ];
    }
}
