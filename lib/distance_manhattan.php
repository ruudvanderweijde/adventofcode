<?php

function manhattan(array $from, array $to): int {
    [$fromY, $fromX, $toY, $toX] = [...$from, ...$to];
    assert(is_int($fromY) && is_int($toY) && is_int($fromX) && is_int($toX));
    return abs($fromY - $toY) + abs($fromX - $toX);
}
