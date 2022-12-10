<?php

const DIRECTIONS = [[1, 0], [-1, 0], [0, 1], [0, -1]];

$rawField = [];
foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $x => $line) {
    foreach (str_split($line) as $y => $char) {
        $rawField[$x][$y] = intval($char);
    }
}

class Point {
    public function __construct(
        public int $x,
        public int $y,
        public int $val,
        public array $basin = [],
    ){}
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

$memory = [];
function getBasin(int $x, int $y, int $val, array $f, array $ls = []): array {
    global $memory;
    foreach (DIRECTIONS as $direction) {
        $_x = $x + $direction[0];
        $_y = $y + $direction[1];
        if (
            ($f[$_x][$_y] ?? false) &&
            $f[$_x][$_y] > $val &&
            $f[$_x][$_y] < 9
        ) {
            if(($memory["{$_x}_{$_y}"] ?? -1) === -1) {
                foreach(getBasin($_x, $_y, $val, $f, $ls) as $b) {
                    $ls["{$_x}_{$_y}"] = 1;
                    $memory["{$_x}_{$_y}"] = 1;
                };
            }
        }
    }
    return $ls;
}
function flatten(Lowpoint $lowPoint, array $ret = []): array {
    $ret["{$lowPoint->x},{$lowPoint->y}"] = $lowPoint;

    foreach($lowPoint->basin as $basin) {
        $flatten = flatten($basin);
        foreach ($flatten as $b) {
            $ret["{$b->x},{$b->y}"] = $b;
        };
    }
    return $ret;
}

$lowPoints = [];
foreach ($rawField as $x => $columns) {
    foreach ($columns as $y => $val) {
        if (
            ($rawField[$x+1][$y] ?? 9) > $val &&
            ($rawField[$x-1][$y] ?? 9) > $val &&
            ($rawField[$x][$y+1] ?? 9) > $val &&
            ($rawField[$x][$y-1] ?? 9) > $val
        ) {
            $lowPoint = new LowPoint(x: $x, y: $y, val: $val);
            $lowPoint->basin = getBasin($x, $y, $val, $rawField);
            $memory = [];
            $lowPoints[] = $lowPoint;
        }
    }
}

$basins = array_map(fn (LowPoint $lp) => count($lp->basin), $lowPoints);
rsort($basins);

echo array_product(array_slice($basins, 0, 3));
echo PHP_EOL;


// fails to work:
// Process finished with exit code 139 (interrupted by signal 11: SIGSEGV)
