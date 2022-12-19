<?php

namespace App\day4;

class Day4
{
    public function __construct()
    {
    }
    public function solve()
    {
        return [
            (new PartOne())->getResult(),
            (new PartTwo())->getResult(),
        ];
    }
}
