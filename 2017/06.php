<?php

function reallocate(array $banks, string|null $matchState = null): int {
    $size = count($banks);
    $history = [];
    while (true) {
        $state = join('_', $banks);
        if ($matchState === null || $matchState === '') {
            if (in_array($state, $history)) { break; }
        } else {
            if ($state === $matchState && count($history) > 0) { break; }
        }
        $history[] = $state;

        $max = max($banks);
        $pointer = array_search($max, $banks);
        $banks[$pointer] = 0;
        while (--$max >= 0) {
            ++$banks[(++$pointer)%$size];
        }
    }
    if ($matchState === null) {
        return count($history);
    }
    return $matchState === '' ? reallocate($banks, $state) : count($history);
}

$banks = [0, 5, 10, 0, 11, 14, 13, 4, 11, 8, 8, 7, 1, 4, 12, 11];
assert(5 === reallocate([0,2,7,0]));
$s = microtime(true);
printf("part1: cycles=%d (in %3f sec)\n", reallocate($banks), microtime(true)-$s);

assert(4 === reallocate([0,2,7,0], ''));
$s = microtime(true);
printf("part2: cycles=%d (in %3f sec)\n", reallocate($banks, ''), microtime(true)-$s);
