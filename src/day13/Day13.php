<?php

namespace App\day13;

class Day13
{
    private array $input = [];

    public function __construct(string $mode)
    {
        $this->input = match ($mode) {
            'input' => file(__DIR__ . DIRECTORY_SEPARATOR . $mode . ".txt", FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES),
            default => file(__DIR__ . DIRECTORY_SEPARATOR . "test.txt", FILE_IGNORE_NEW_LINES + FILE_SKIP_EMPTY_LINES)
        };
    }

    public function solve()
    {
        $validGroups = [];
        echo "i am stupid and i don't know how to solve this problem\n";
        $inputGroups = array_map(
            fn ($chunk) => array_map(
                fn ($line) => json_decode($line),
                $chunk
            ),
            array_chunk($this->input, 2)
        );
        $validGroups = array_map(fn ($group) => $this->comp($group[0], $group[1]), $inputGroups);
        return [0, 0];
    }

    public function comp($left, $right)
    {
        $valid = true;
        if (is_int($left)) {
            if (is_int($right)) {
                // both are integers
                return $left <= $right;
            } else {
                return $this->comp([$left], $right);
            }
            return $valid;
        } else {
            if (is_int($right)) {
                return $this->comp($left, [$right]);
            }
        }

        foreach ($left as $key => $leftValue) {
            if (!array_key_exists($key, $right)) {
                continue;
            } else {
                $valid = $this->comp($leftValue, $right[$key]);
            }
        }
        return $valid;
        var_dump($valid);
    }
}
