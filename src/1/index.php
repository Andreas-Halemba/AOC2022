<?php

$input = fopen("./src/input.txt", "r");
if ($input) {
    $groupIndex = 0;
    $calories = [];
    while (($line = fgets($input))) {
        if ((int) $line === 0) {
            $groupIndex++;
            continue;
        } else {
            $calories[$groupIndex][] = $line;
        }
    }

    fclose($input);
}
$elfen = array_map(fn ($calorieList) => array_sum($calorieList), $calories);
arsort($elfen);
$top3 = array_splice($elfen, 0, 3);
echo "Most Cal one Elf: " . $elfen[array_key_first($elfen)] . "\n";
echo "Cal top3 Elves: " . (int) array_sum($top3) . "\n";
