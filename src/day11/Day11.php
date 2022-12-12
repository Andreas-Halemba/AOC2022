<?php

namespace App\day11;

class Day11
{
    /**
     * @var Monkey[] $monkeys
     */
    private array $monkeys;

    private array $inspectionCounter;

    public int $totalModul;

    public function __construct(string $env = "test")
    {
        $file = file(__DIR__ . DIRECTORY_SEPARATOR . $env . ".txt", FILE_IGNORE_NEW_LINES);
        $this->prepareMonkeys($file);
        $modulos = [];
        for ($i = 0; $i < count($this->monkeys); $i++) {
            $modulos[] = $this->monkeys[$i]->getModulo();
        }
        $this->totalModul = array_product($modulos);
        var_dump($modulos, $this->totalModul);
        for ($i = 0; $i < 10000; $i++) {
            foreach ($this->monkeys as $monkey) {
                /** @var Monkey $monkey */
                $monkey->checkItems($this->monkeys, $this->inspectionCounter, $this->totalModul);
                // print_r(array_column($this->monkeys, 'items'));
            }
        }
        arsort($this->inspectionCounter);
        var_dump($this->inspectionCounter);
        var_dump(
            array_product(array_slice($this->inspectionCounter, 0, 2))
        );
    }

    private function prepareMonkeys(array $file): void
    {
        $file = array_values(array_filter($file, fn ($line) => !empty($line)));
        $monkeyBlocks = array_chunk($file, 6);
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
            $this->inspectionCounter[$monkeyNumber] = 0;

            $this->monkeys[$monkeyNumber] = new Monkey($monkeyNumber, $items[0], $operation, [$testCondition[0], $testTrue[0], $testFalse[0]]);
        }
    }
}
