<?php

const DIRECTIONS = [
    [ 1,  0],
    [-1,  0],
    [ 0,  1],
    [ 0, -1],
];

$field = [];
foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $x => $line) {
    foreach (str_split($line) as $y => $char) {
        $field[$x][$y] = intval($char);
    }
}

class LowPoint {
    public function __construct(
        public int $x,
        public int $y,
        public int $val,
        /** LowPoint[] */
        public array $basin = [],
    ){}
}

function getBasin(int $x, int $y, int $val, array $f, array $ls = []): array {
    foreach (DIRECTIONS as $direction) {
        $_x = $x + $direction[0];
        $_y = $y + $direction[1];
        $_val = $f[$_x][$_y] ?? false;

        if (
            $_val &&
            $_val > $val &&
            $_val < 9
        ) {
            $ls["{$_x}_{$_y}"] = 1;
            $ls += getBasin($_x, $_y, $_val, $f, $ls);
        }
    }
    return $ls;
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
            $lowPoint = new LowPoint(x: $x, y: $y, val: $val);
            $lowPoint->basin = getBasin($x, $y, $val, $field);
            $lowPoints[] = $lowPoint;
        }
    }
}

$basins = array_map(fn (LowPoint $lp) => 1+count($lp->basin), $lowPoints);
rsort($basins);

echo array_product(array_slice($basins, 0, 3));
echo PHP_EOL;
