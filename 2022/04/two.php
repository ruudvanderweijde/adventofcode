<?php

function handle(string $filename): int
{
    return count(
        array_filter(
            file($filename),
            function(string $line): bool {
                preg_match('/(\d+)-(\d+),(\d+)-(\d+)/', rtrim($line), $matches);
                [, $ll, $lr, $rl, $rr] = $matches;
                return count(array_intersect(range($ll, $lr), range($rl, $rr))) > 0;
            }
        )
    );
}

$testScore = handle('input-test');
assert(4 === $testScore, sprintf('Expected 4, got [%d] instead.', $testScore));

var_dump(handle('input'));
