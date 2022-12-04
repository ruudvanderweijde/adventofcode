<?php

function handle(string $filename): int
{
    $doubles = 0;
    if ($handle = fopen($filename, "r")) {
        while (($line = fgets($handle)) !== false) {
            preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', rtrim($line), $matches);
            [, $ll, $lr, $rl, $rr] = $matches;
            $doubles += array_intersect(range($ll, $lr), range($rl, $rr))? 1 : 0;
        }
        fclose($handle);
    }

    return $doubles;
}

$testScore = handle('input-test');
assert(4 === $testScore, sprintf('Expected 4, got [%d] instead.', $testScore));

var_dump(handle('input'));
