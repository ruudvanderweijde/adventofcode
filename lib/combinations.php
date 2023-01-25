<?php

function combinations(Iterable $set = [], $size = 0): Generator {
    if ($size == 0) {
        yield []; // end of recursion
    } elseif ($set) {
        $prefix = [array_shift($set)];

        foreach (combinations($set, $size-1) as $suffix) {
            yield array_merge($prefix, $suffix);
        }

        foreach (combinations($set, $size) as $next) {
            yield $next;
        }
    }
}
