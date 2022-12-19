<?php

namespace App;

class GlobalHelpers
{
    public function readInput(string $lineHandler, string $dayDir): void
    {
        if (($input = fopen('./src/' . $dayDir . '/input.txt', 'r'))) {
            $lineCount = 0;
            while (($line = fgets($input))) {
                $lineCount++;
                $this->$lineHandler($line, $lineCount);
            }
        }
    }

    public function readTestInput(string $lineHandler, string $dayDir): void
    {
        if (($input = fopen('./src/' . $dayDir . '/test.txt', 'r'))) {
            $lineCount = 0;
            while (($line = fgets($input))) {
                $lineCount++;
                $this->$lineHandler($line, $lineCount);
            }
        }
    }
    
    public static function nl(string $string): void
    {
        print_r($string . PHP_EOL);
    }
}
