<?php
require_once('../lib/distance_manhattan.php');
require_once('../lib/assert.php');
require_once('../lib/partEnum.php');

const DIRECTIONS = [
    [ 1, 0], // down
    [ 0, 1], // right
    [-1, 0], // up
    [ 0,-1], // left
];

function distance(int $max, Part $part = Part::ONE): int {
    $direction = 0;
    $counter = 0;
    $x = $y = 0;
    $grid[$y][$x] = ++$counter;

    while ($counter < $max) {
        echo "$counter / $max \r";
        [$nextY, $nextX] = DIRECTIONS[($direction+1)%4];
        // if next direction is free
        if (($grid[$y + $nextY][$x + $nextX] ?? -1) === -1) {
            $direction = ($direction+1) % 4;
        }
        [$_y, $_x] = DIRECTIONS[$direction];
        $y += $_y;
        $x += $_x;
        if ($part === Part::ONE) {
            ++$counter;
        } elseif ($part === Part::TWO) {
            $counter = array_sum(
                array_map(
                    fn (array $d): int => $grid[$y+$d[0]][$x+$d[1]] ?? 0,
                    [[0,1],[0,-1],[1,1],[1,-1],[-1,1],[-1,-1],[1,0],[-1,0]]
                )
            );
        }
        $grid[$y][$x] = $counter;
    }

    return $part === Part::ONE ? manhattan([0,0], [$y, $x]) : $counter;
}

assertSame(0, distance(1));
assertSame(3, distance(12));
assertSame(2, distance(23));
assertSame(31, distance(1024));

$s = microtime(true);
printf("part1: distance=%d (in %3f sec)\n", distance(289326), microtime(true)-$s);

$s = microtime(true);
printf("part2: value=%d (in %3f sec)\n", distance(289326, Part::TWO), microtime(true)-$s);
