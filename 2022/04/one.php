<?php

function handle(string $filename): int
{
    return count(
        array_filter(
            file($filename),
            function(string $line): bool {
                preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', rtrim($line), $matches);
                [, $ll, $lr, $rl, $rr] = $matches;
                return ($ll <= $rl && $lr >= $rr) || ($ll >= $rl && $lr <= $rr );
            }
        )
    );
}

$testScore = handle('input-test');
assert(2 === $testScore, sprintf('Expected 2, got [%d] instead.', $testScore));

var_dump(handle('input'));
