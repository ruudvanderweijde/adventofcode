<?php

$s = microtime(true);
$ranges = array_map(fn (string $range) => explode('-', $range), file('20.input', FILE_IGNORE_NEW_LINES));
const MAX = 4294967295;
$min = -1;
$count = 0;
for ($i=0;$i<MAX; $i++) {
    foreach($ranges as $range) {
        if ($i >= $range[0] && $i <= $range[1]) {
            $i = $range[1];
            continue 2;
        }
    }
    ++$count;
    if ($min === -1) {
        printf("part1: min=%d in (%3f seconds)\n", $i, microtime(true) - $s);
        $min = $i;
    }
}
printf("part2: count=%d in (%3f seconds)\n", $count, microtime(true) - $s);
