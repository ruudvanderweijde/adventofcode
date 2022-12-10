<?php

$field = [];
foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $x => $line) {
    foreach (str_split($line) as $y => $char) {
        $field[$x][$y] = intval($char);
    }
}

$lowPoints = [];
foreach ($field as $x => $columns) {
    foreach ($columns as $y => $val) {
        if (
            ($field[$x+1][$y] ?? 9) > $val &&
            ($field[$x-1][$y] ?? 9) > $val &&
            ($field[$x][$y+1] ?? 9) > $val &&
            ($field[$x][$y-1] ?? 9) > $val
        ) {
            $lowPoints[] = $val;
        }
    }
}

echo array_sum($lowPoints) + count($lowPoints);
echo PHP_EOL;
