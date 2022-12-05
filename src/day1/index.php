<?php

$filePath = "./src/day1/input.txt";
if (file_exists($filePath)) {
    $groupIndex = 0;
    $calories = [];
    $lines = file($filePath);
    if ($lines) {
        foreach ($lines as $line) {
            if (strlen(trim($line)) === 0) {
                $groupIndex++;
                continue;
            }
            $calories[$groupIndex][] = $line;
        }
    }
    $elfen = array_map(fn ($calorieList) => array_sum($calorieList), $calories);
    arsort($elfen);
    $top3 = array_splice($elfen, 0, 3);
    echo "Most Cal one Elf: " . $elfen[array_key_first($elfen)] . "\n";
    echo "Cal top3 Elves: " . (int) array_sum($top3) . "\n";
}
