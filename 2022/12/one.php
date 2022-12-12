<?php

const DIRECTIONS = [[0,-1],[1,0],[0,1],[-1,0]];

$startVal = ord('a') - 1;
$endVal = ord('z') + 1;
$map = array_map(
    fn(string $line) => array_map(
        fn(string $char) => match($char) { 'S' => $startVal, 'E' => $endVal, default => ord($char) },
        str_split($line)
    ),
    array_map('rtrim', file($argv[1] ?? 'input-test'))
);

$startPos = '';
$endPos = '';

foreach ($map as $x => $ys) {
    foreach ($ys as $y => $v) {
        if ($v === $startVal) { $startPos = [$x,$y]; }
        if ($v === $endVal) { $endPos = [$x,$y]; }
    }
}

function shortestDistance(array $grid, array $start, array $end) {
    $bestDistances = array_fill(0, count($grid), array_fill(0, count($grid[0]), PHP_INT_MAX));
    $bestDistances[$start[0]][$start[1]] = 0;

    $queue = [$start];
    while (count($queue) > 0) {
        [$x, $y] = array_shift($queue);
        $v = $grid[$x][$y];
        $currentDistance = $bestDistances[$x][$y];
        foreach (DIRECTIONS as $d) {
            $_x = $x + $d[0];
            $_y = $y + $d[1];
            if (!$_v = ($grid[$_x][$_y] ?? null)) {
                continue;
            }
            if ($_v - $v <= 1 && $currentDistance + 1 < $bestDistances[$_x][$_y]) {
                array_push($queue, [$_x, $_y]);
                $bestDistances[$_x][$_y] = $currentDistance + 1;
            }
        }
    }
    return $bestDistances[$end[0]][$end[1]];
}
echo shortestDistance($map, $startPos, $endPos);
echo PHP_EOL;
