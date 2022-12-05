<?php

namespace App\day5;

use App\GlobalHelpers;

class PartOne extends GlobalHelpers
{
    public function __construct(
        private string $part = 'one',
        private int $storagePlaces = 9,
        private string $filename = 'input'
    ) {
        $lines = file('./src/day5/' . $this->filename . '.txt');
        $storage = [];
        $instructions = [];
        foreach ($lines as $lineNumber => $lineContent) {
            if (strlen(trim($lineContent)) === 0) {
                continue;
            }
            if (strstr($lineContent, "[")) {
                for ($i = 0; $i < $this->storagePlaces; $i++) {
                    $colName = 'col' . ($i + 1);
                    $storage[$lineNumber][$colName] = substr($lineContent, $i * 4, 3);
                }
            }
            if (strstr($lineContent, 'from')) {
                [$_, $move, $_, $from, $_, $to] = explode(' ', trim($lineContent));
                $instructions[$lineNumber] = [$move, $from, $to];
            }
        }
        $stacks = [];
        foreach ($storage as $storageLine) {
            $storageLine = array_filter($storageLine, fn ($stack) => strlen(trim($stack)) > 0);
            $stacks = array_merge_recursive($stacks, $storageLine);
        }
        foreach ($stacks as &$stack) {
            if (gettype($stack) === 'string') {
                $stack = [$stack];
            };
        }
        ksort($stacks);
        foreach ($instructions as $instruct) {
            [$move, $from, $to] = $instruct;
            $payloads = array_splice($stacks['col' . $from], 0, (int) $move, null);
            if ($this->part === 'one') {
                foreach ($payloads as $payload) {
                    array_unshift($stacks['col' . $to], $payload);
                }
            } else {
                $stacks['col' . $to] = array_merge($payloads, $stacks['col' . $to]);
            }
        }
        $result = '';
        for ($i = 0; $i < $this->storagePlaces; $i++) {
            $result .= $stacks['col' . ($i + 1)][0];
        }
        var_dump(str_replace(["[", "]"], '', $result));
    }
}
