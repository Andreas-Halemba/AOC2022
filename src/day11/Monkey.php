<?php

namespace App\day11;

class Monkey
{
    public function __construct(
        public int $id,
        public array $items,
        private array $operation,
        private array $test
    ) {
    }

    /**
     * @param Monkey[] $monkeys
     * @return void
     */
    public function checkItems(&$monkeys, &$counter, $round)
    {
        foreach ($this->items as $item) {
            var_dump(substr((string)$item,0, strpos((string)$item, 'E')));
            $itemOperation = $this->operation;
            array_walk($itemOperation, fn (&$value) => $value = str_replace('old', $item, $value));

            if ($itemOperation[1] === '+') {
                $new = array_sum([$itemOperation[0], $itemOperation[2]]);
            }
            if ($itemOperation[1] === '*') {
                $new = array_product([$itemOperation[0], $itemOperation[2]]);
            }

            $counter[$this->id]++;

            if ((floor($new / 3) % $this->test[0]) === 0) {
                $this->removeFirstItem();
                $monkeys[$this->test[1]]->addItem(floor($new / 3));
            } else {
                $this->removeFirstItem();
                $monkeys[$this->test[2]]->addItem(floor($new / 3));
            }
        }
    }

    public function addItem(float $item): void
    {
        $this->items[] = $item;
    }

    public function removeFirstItem(): float
    {
        return array_shift($this->items);
    }
}
