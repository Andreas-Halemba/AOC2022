<?php

namespace App\day11;

class Monkey
{
    public function __construct(
        public array $items,
        public array $operation,
        private array $test
    ) {
    }

    public function checkItems(&$monkeys)
    {
        foreach ($this->items as $item) {
            $itemOperation = $this->operation;
            array_walk($itemOperation, fn (&$value) => $value = str_replace('old', $item, $value));

            if ($itemOperation[1] === '+') {
                $new = array_sum([$itemOperation[0], $itemOperation[2]]);
            }
            if ($itemOperation[1] === '*') {
                $new = array_product([$itemOperation[0], $itemOperation[2]]);
            }

            var_dump([join(' ', $itemOperation), $new, $this->test]);
        }
    }

    public function addItem(int $item): void
    {
        $this->items[] = $item;
    }

    public function removeFirstItem(): int
    {
        return array_shift($this->items);
    }
}
