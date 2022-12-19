<?php

namespace App\day7;

use Exception;

class Day7
{
    private array $file;


    public function __construct(?string $test)
    {
        if ($test) {
            $this->file = file('./src/day7/test.txt', FILE_IGNORE_NEW_LINES);
        } else {
            $this->file = file('./src/day7/input.txt', FILE_IGNORE_NEW_LINES);
        }
    }

    public function solve()
    {
        $result = $this->parseFile();
        return [$result[0], $result[1]];
    }

    public function parseFile()
    {
        $lines = [];
        $lines = array_filter($this->file, function ($line) {
            return preg_match('/^\$\s(cd)/', $line) || preg_match('/^(\d*)\s(\w*)/', $line);
        });
        [$tree, $_] = $this->processLines(array_values($lines), []);
        [$totalSize, $folderSizeList] = $this->calcDirSizes($tree, []);
        $relevantFoldersList = array_filter($folderSizeList, fn ($size) => $size <= 100000);
        $requiredSpace = 30000000 - (70000000 - $totalSize);
        $deletableFolders = array_filter($folderSizeList, fn ($folderSize) => $folderSize > $requiredSpace);
        asort($deletableFolders);
        return [
            $totalSize,
            join('|', $deletableFolders)
        ];
    }

    public function processLines(array $lines, array $tree): array
    {
        for ($lineNumber = 0; $lineNumber < count($lines); $lineNumber++) {
            if (preg_match('/^\$\s(cd)\s(\.\.)$/', $lines[$lineNumber], $command)) {
                return [$tree, $lineNumber];
            } elseif (preg_match('/^\$\s(cd)\s(\S+)$/', $lines[$lineNumber], $command)) {
                $linesLeft = array_slice($lines, $lineNumber + 1);
                [$branch, $line] = $this->processLines($linesLeft, []);
                $lineNumber += $line + 1;
                $tree[$command[2]] = $branch;
            } elseif (preg_match('/^(\d*)\s(\S*)/', $lines[$lineNumber], $file)) {
                $tree[$file[2]] = $file[1];
            } else {
                throw new Exception('hin');
            }
        }
        return [$tree, count($lines)];
    }

    public function calcDirSizes(array $tree)
    {
        $contentSizeSum = 0;
        $subFolderSizes = [];
        foreach ($tree as $folderContent) {
            if (gettype($folderContent) === 'array') {
                [$folderSize, $folderSubSize] = $this->calcDirSizes($folderContent);
                $contentSizeSum += $folderSize;
                $subFolderSizes = array_merge($subFolderSizes, $folderSubSize);
            } else {
                $contentSizeSum += $folderContent;
            }
        }
        $subFolderSizes[] = $contentSizeSum;
        return [$contentSizeSum, $subFolderSizes];
    }
}
