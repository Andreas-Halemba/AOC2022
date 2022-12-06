<?php

namespace App\day6;

class Day6
{
    private array $text = [
        'mjqjpqmgbljsphdztnvjfqwrcgsmlb',
        'bvwbjplbgvbhsrlpgdmjqwftvncz',
        'nppdvjthqldpwncqszvftbrmjlhg',
        'nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg',
        'zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw',
    ];

    public function __construct(?string $test)
    {
        if (!$test) {
            $this->text = file('./src/day6/input.txt');
        }
        foreach ($this->text as $data) {
            print_r([
                '4' => $this->findUnique($data, 4),
                '14' => $this->findUnique($data, 14),
            ]);
        }
    }
    private function findUnique(string $data, int $uniqueCount): int
    {
        for ($i = $uniqueCount; $i < strlen($data); $i++) {
            if (count(array_unique(str_split(substr($data, $i - $uniqueCount, $uniqueCount)))) === $uniqueCount) {
                return $i;
            }
        }
        return 0;
    }
}
