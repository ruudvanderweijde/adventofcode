<?php

function josephus(int $count): int {
    $bin = str_split(decbin($count));
    $first = array_shift($bin);
    return bindec(join($bin + [PHP_INT_MAX=>$first]));
}

function winner(int $n): int {
    $w = 1;
    for ($i=1; $i<$n; $i++) {
        $w = $w % $i + 1;
        if ($w > ($i + 1)/2) {
            $w++;
        }
    }
    return $w;
}

assert(3 === ($real = josephus(5)), "expected 3 got $real");
assert(15 === ($real = josephus(15)), "expected 15 got $real");
assert(73 === ($real = josephus(100)), "expected 73 got $real");

$s = microtime(true);
printf("part1: elf=%d in (%3f seconds)\n", josephus(3012210), microtime(true) - $s);

$s = microtime(true);
printf("part2: elf=%d in (%3f seconds)\n", winner(3012210), microtime(true) - $s);
