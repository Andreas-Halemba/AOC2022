<?php

namespace App\day11;

class Monkey
{
    public function __construct(
        public int $id,
        public array $items,
        public array $operation,
        public array $test
    ) {
    }

    /**
     * @param Monkey[] $monkeys
     * @return void
     */
    public function checkItems(&$monkeys, &$counter, $modulo)
    {
        foreach ($this->items as $item) {
            $itemOperation = $this->operation;
            array_walk($itemOperation, fn (&$value) => $value = str_replace('old', $item, $value));

            if ($itemOperation[1] === '+') {
                $newLevel = array_sum([$itemOperation[0], $itemOperation[2]]);
            }
            if ($itemOperation[1] === '*') {
                $newLevel = array_product([$itemOperation[0], $itemOperation[2]]);
            }

            $counter[$this->id]++;

            // var_dump([
            //     'calc' => $newLevel . " % " . $modulo,
            //     "modulo rest" => $newLevel % $this->getModulo()
            // ]);

            $level = $newLevel % $modulo;
            if (($newLevel % $this->test[0]) === 0) {
                $this->removeFirstItem();
                $monkeys[$this->test[1]]->addItem($level);
            } else {
                $this->removeFirstItem();
                $monkeys[$this->test[2]]->addItem($level);
            }
        }
    }

    public function getModulo(): int
    {
        return  $this->test[0];
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
