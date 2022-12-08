<?php

$field = [];
foreach (file($argv[1] ?? 'input-test') as $line) {
    preg_match('/(\d+),(\d+) -> (\d+),(\d+)/', rtrim($line), $matches);
    [, $lx, $ly, $rx, $ry] = $matches;

    if ($lx === $rx) {
        for ($j = min($ly, $ry); $j <= max($ly, $ry); ++$j) {
            $field[$j][$lx] = ($field[$j][$lx] ?? 0) + 1;
        }
    } else if ($ly === $ry) {
        for ($i = min($lx, $rx); $i <= max($lx, $rx); ++$i) {
            $field[$ly][$i] = ($field[$ly][$i] ?? 0) + 1;
        }
    } else {
        // skipping for now
    }
}

echo array_sum(array_map(fn($i)=>array_sum(array_map(fn($j)=>$j>1?1:0,$i)),$field));
echo PHP_EOL;
