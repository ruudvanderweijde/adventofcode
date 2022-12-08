<?php

$filename = $argv[1] ?? 'input-test';

$field = [];
foreach (array_map('rtrim', file($filename)) as $x => $line) {
    foreach (str_split($line) as $y => $char) {
        $field[$x][$y] = intval($char);
    }
}
[$min, $max] = [min(array_keys($field)), max(array_keys($field))];

function lookAhead(array $field, array $toLookup, int $val) {
    $count = 0;
    foreach ($toLookup as $list) {
        foreach ($list as $x => $y) {
            ++$count;
            if ($field[$x][$y] >= $val) {
                break 2;
            }
        }
    }
    return $count;
}
$scenicScore = [];
foreach($field as $x => $ys) {
    foreach($ys as $y => $val) {
        // skip edges
        if (in_array($x, [$min, $max]) || in_array($y, [$min, $max])) {
            continue;
        } else {
            $f = fn ($k, $v) => [$k=>$v];
            $size = [
                lookAhead($field, array_map($f, range($x-1, $min, -1), array_fill(0, $x, $y)), $val),
                lookAhead($field, array_map($f, range($x+1, $max), array_fill(0, $max-$x, $y)), $val),
                lookAhead($field, array_map($f, array_fill(0, $y, $x), range($y-1, $min, -1)), $val),
                lookAhead($field, array_map($f, array_fill(0, $max-$y, $x), range($y+1, $max)), $val),
            ];
            $scenicScore["{$x}_{$y}"] = array_product($size);
        }
    }
}

echo max($scenicScore) . PHP_EOL;
