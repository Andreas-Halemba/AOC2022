<?php

namespace App\day11;

class Day11
{
    private array $monkeys;

    public function __construct(string $env = "test")
    {
        $file = file(__DIR__ . DIRECTORY_SEPARATOR . $env . ".txt", FILE_IGNORE_NEW_LINES);
        $this->prepareMonkeys($file);
        for ($i = 0; $i < 1; $i++) {
            foreach ($this->monkeys as $number => $monkey) {
                /** @var Monkey $monkey */
                $monkey->checkItems($this->monkeys);
            }
        }
    }

    private function prepareMonkeys(array $file): void
    {
        foreach ($file as $lineNumber => $line) {
            if ($line === '') {
                $monkeyBlocks[] = array_slice($file, $lineNumber - 6, 6);
            }
        }
        foreach ($monkeyBlocks as $monkeyNumber => $monkeyInfo) {
            preg_match_all('/(\d{2})/', $monkeyInfo[1], $items);
            array_shift($items);

            preg_match('/(\S+|\d+)\s(\+|\*)\s(\S+|\d+)/', $monkeyInfo[2], $operation);
            array_shift($operation);

            preg_match('/(\d+)/', $monkeyInfo[3], $testCondition);
            array_shift($testCondition);

            preg_match('/(\d+)/', $monkeyInfo[4], $testTrue);
            array_shift($testTrue);

            preg_match('/(\d+)/', $monkeyInfo[5], $testFalse);
            array_shift($testFalse);

            $this->monkeys[] = new Monkey($items[0], $operation, [$testCondition, $testTrue, $testFalse]);
        }
    }
}
