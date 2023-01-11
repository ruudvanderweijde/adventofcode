<?php
$s = microtime(true);

const START = 20151125;
const MULTIPLIER = 252533;
const DIVIDER = 33554393;

const COLUMN = 2947;
const ROW = 3029;

$grid = [];
$prev = 0;

for($i=1; $i<INF; ++$i) {
    for($y=$i,$x=1; $y>0; --$y, ++$x) {
        $prev = $prev > 0 ? ($prev * MULTIPLIER) % DIVIDER : START;
        if ($y === COLUMN && $x === ROW) {
            printf("answer=%d (in %3f sec)\n", $prev, microtime(true)-$s);
            exit(1);
        }
        $grid[$y][$x] = $prev;
    }
}