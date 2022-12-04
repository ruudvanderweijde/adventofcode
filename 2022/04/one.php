<?php

function handle(string $filename): int
{
    $doubles = 0;
    if ($handle = fopen($filename, "r")) {
        while (($line = fgets($handle)) !== false) {
            preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', rtrim($line), $matches);
            [, $ll, $lr, $rl, $rr] = $matches;
            $doubles += ($ll <= $rl && $lr >= $rr) || ($ll >= $rl && $lr <= $rr ) ? 1 : 0;
        }
        fclose($handle);
    }

    return $doubles;
}

$testScore = handle('input-test');
assert(2 === $testScore, sprintf('Expected 2, got [%d] instead.', $testScore));

var_dump(handle('input'));
