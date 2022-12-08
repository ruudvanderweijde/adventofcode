<?php

$filename = $argv[1] ?? 'input-test';

$field = [];
foreach (array_map('rtrim', file($filename)) as $x => $line) {
    foreach (str_split($line) as $y => $char) {
        $field[$x][$y] = intval($char);
    }
}
[$min, $max] = [min(array_keys($field)), max(array_keys($field))];

$visible = 0;
foreach($field as $x => $ys) {
    foreach($ys as $y => $val) {
        if (
            in_array($x, [$min, $max]) ||
            in_array($y, [$min, $max]) ||
            0 === count(array_filter(range($min, $x-1), fn (int $_x) => $field[$_x][$y] >= $val)) ||
            0 === count(array_filter(range($x+1, $max), fn (int $_x) => $field[$_x][$y] >= $val)) ||
            0 === count(array_filter(range($min, $y-1), fn (int $_y) => $field[$x][$_y] >= $val)) ||
            0 === count(array_filter(range($y+1, $max), fn (int $_y) => $field[$x][$_y] >= $val))
        ) {
            ++$visible;
        }
    }
}
echo $visible . PHP_EOL;
