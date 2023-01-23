<?php

const Safe = '.';
const Trap = '^';

function safeTiles(string $in, int $rows): int {
    $res[] = $in;
    while (--$rows > 0) {
        $next = '';
        for($i=0;$i<strlen($in);$i++) {
            $l = $i === 0 ? Safe : $in[$i-1];
            $c = $in[$i];
            $r = $i === strlen($in)-1 ? Safe : $in[$i+1];

            $next .= ($l === Trap && $c === Trap && $r === Safe)
            || ($c === Trap && $r === Trap && $l === Safe)
            || ($c === Safe && $r === Safe && $l === Trap)
            || ($l === Safe && $c === Safe && $r === Trap)
                ? Trap : Safe;
        }
        $res[] = $in = $next;
    }

    return array_sum(array_map(fn (string $line) => substr_count($line, Safe), $res));
}

assert(38 === safeTiles('.^^.^.^^^^', 10));

$input = '.^^^.^.^^^.^.......^^.^^^^.^^^^..^^^^^.^.^^^..^^.^.^^..^.^..^^...^.^^.^^^...^^.^.^^^..^^^^.....^....';
$s = microtime(true);
printf("part1: count=%s in (%3f seconds)\n", safeTiles($input, 40), microtime(true) - $s);

$s = microtime(true);
printf("part2: count=%s in (%3f seconds)\n", safeTiles($input, 400000), microtime(true) - $s);
