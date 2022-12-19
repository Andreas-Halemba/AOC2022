<?php

namespace App\day10;

class Day10
{
    private int $sum = 1;

    private int $cycleCounter = 0;

    private array $signalMessures = [];

    private array $breakpoints = [20, 60, 100, 140, 180, 220];

    private array $sprite = [];

    private array $picture = [];

    public function __construct()
    {
    }

    public function solve()
    {
        $file = file(__DIR__ . DIRECTORY_SEPARATOR . "input.txt", FILE_IGNORE_NEW_LINES);
        foreach ($file as $line) {
            $this->processLine($line);
        }
        var_dump(array_sum($this->signalMessures));
        echo join(PHP_EOL, str_split(join('', $this->picture), 40));
    }

    public function generateSprite()
    {
        $dots = array_fill(-2, 45, '.');
        $dots[$this->cycleCounter % 40] =  '#';
        $dots[($this->cycleCounter % 40) - 1] =  '#';
        $dots[($this->cycleCounter % 40) + 1] =  '#';
        $this->sprite = $dots;
    }

    private function processLine($line)
    {
        @[$command, $value] = explode(' ', $line);
        $processDuration = match ($command) {
            'addx' => 2,
            default => 1,
        };
        $currentCounter = $this->cycleCounter;
        $endCycel = $currentCounter + $processDuration;
        while ($this->cycleCounter < $endCycel) {
            $this->generateSprite();
            if (in_array($this->cycleCounter, $this->breakpoints, true)) {
                $signal = $this->cycleCounter * $this->sum;
                $this->signalMessures[] = $signal;
            }
            if (array_key_exists($this->sum, $this->sprite)) {
                $this->picture[] = $this->sprite[$this->sum];
            } else {
                $this->picture[] = '.';
            }
            if ($value && $this->cycleCounter + 1 === $endCycel) {
                $this->sum += $value;
            }
            $this->cycleCounter++;
        }
    }
}
