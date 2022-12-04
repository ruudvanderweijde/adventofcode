<?php

$points = array_flip(array_merge([0 => 'nil'], range('a', 'z'), range('A', 'Z')));

function handle(string $filename): int
{
    global $points;

    $score = 0;
    if ($handle = fopen($filename, "r")) {
        $stock = [];
        while (($line = fgets($handle)) !== false) {
            array_push($stock, rtrim($line));
            if (count($stock) < 3) continue;

            $label = array_unique(array_intersect(str_split($stock[0]), str_split($stock[1]), str_split($stock[2])));
            $score += $points[current($label)];
            $stock = [];
        }
        fclose($handle);
    }

    return $score;
}

$testScore = handle('input-test');
assert(70 === $testScore, sprintf('Expected 70, got [%d] instead.', $testScore));

var_dump(handle('input'));
