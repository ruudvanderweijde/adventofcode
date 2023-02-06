<?php
require_once('../lib/assert.php');

const DIRECTIONS = [
    // x, y , z
    'n'  => [ 0,+1,-1],
    'ne' => [ 1, 0,-1],
    'se' => [ 1,-1, 0],
    's'  => [ 0,-1, 1],
    'sw' => [-1, 0, 1],
    'nw' => [-1, 1, 0],
];

function distance(array $input): array {
    $x = $y = $z = 0;
    $max = PHP_INT_MIN;
    foreach ($input as $d) {
        [$_x, $_y, $_z] = DIRECTIONS[$d];
        $x += $_x;
        $y += $_y;
        $z += $_z;
        $max = max($max, hexDistance($x, $y, $z));
    }

    return [hexDistance($x, $y, $z), $max];
}

function hexDistance(int $x, int $y, int $z): int|float
{
    return (abs($x) + abs($y) + abs($z)) / 2;
}

assertSame([3,3], distance(['ne','ne','ne']));
assertSame([0,2], distance(['ne','ne','sw','sw']));
assertSame([2,2], distance(['ne','ne','s','s']));
assertSame([3,3], distance(['se','sw','se','sw','sw']));

$s = microtime(true);
$input = explode(',', trim(file_get_contents('11.input')));
[$distance, $max] = distance($input);
printf("part1: distance=%d (in %3f sec)\n", $distance, microtime(true)-$s);
printf("part2: max=%d (in %3f sec)\n", $max, microtime(true)-$s);
