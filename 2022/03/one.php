<?php

$points = array_flip(array_merge([0 => 'nil'], range('a', 'z'), range('A', 'Z')));

function handle(string $filename): int
{
    global $points;

    $score = 0;
    if ($handle = fopen($filename, "r")) {
        while (($line = fgets($handle)) !== false) {
            $input = rtrim($line);
            [$first, $second] = str_split($input, ceil(strlen($input) / 2));
            foreach (array_unique(array_intersect(str_split($first), str_split($second))) as $duplicate) {
                $score += $points[$duplicate];
            }
        }
        fclose($handle);
    }

    return $score;
}

$testScore = handle('input-test');
assert(157 === $testScore, sprintf('Expected 157, got [%d] instead.', $testScore));

var_dump(handle('input'));
