<?php
const DIRECTIONS = [[-1,0],[0,1],[1,0],[0,-1]];

function solve(int $input, array $destination = [], $maxSteps = 0): int
{
    $start = [1,1];

    $isWall = fn(array $p, int $add) => substr_count(decbin(($p[0] * $p[0] + 3 * $p[0] + 2 * $p[0] * $p[1] + $p[1] + $p[1] * $p[1]) + $add), '1') % 2;
    $flatten = fn(array $p): string => sprintf('%d_%d', $p[0], $p[1]);
    $isValidPos = fn(array $p): bool => $p[0] >= 0 && $p[1] >= 0;

    $queue = [[0, $start, $start]];
    $distanceMap = [];
    $min = PHP_INT_MAX;

    while (count($queue) > 0) {
        [$distance, $pos, $prev] = array_shift($queue);
        if ($pos === $destination) { $min = min($min, $distance); }
        if ($maxSteps > 0 && $distance > $maxSteps) { continue; }

        $distanceMap[$flatten($pos)] = min($distanceMap[$flatten($pos)] ?? PHP_INT_MAX, $distance);
        foreach (DIRECTIONS as $d) {
            $nextPos = array_map(fn() => array_sum(func_get_args()), $pos, $d);
            if ($nextPos === $prev) { continue; }
            if (!$isValidPos($nextPos)) { continue; }
            if ($isWall($nextPos, $input)) { continue; }
            if ($distance + 1 < ($distanceMap[$flatten($nextPos)] ?? PHP_INT_MAX)) {
                $queue[] = [$distance + 1, $nextPos, $pos];
            }
        }
    }
    return !empty($destination) ? $min : count($distanceMap);
}

assert(11 === solve(input: 10, destination: [7,4]));
$s = microtime(true);
printf("part1: min_distance=%d in (%3f seconds)\n", solve(input: 1358, destination: [31,39]), microtime(true) - $s);

$s = microtime(true);
printf("part2: locations=%d in (%3f seconds)\n", solve(input: 1358, maxSteps: 50), microtime(true) - $s);

//297 = too high
//289 = too high