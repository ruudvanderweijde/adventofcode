<?php
require_once(__DIR__.'/../lib/assert.php');

$input = file('02.input', FILE_IGNORE_NEW_LINES);

function toNumbers(array $input): array {
    return array_map(
        fn(string $in) => array_map('intval', explode(' ', $in)),
        preg_replace('/\s+/', ' ', $input)
    );
}

function checksum(array $input): int {
    return array_sum(array_map(fn (array $numbers): int => max($numbers) - min($numbers), toNumbers($input)));
}

assertSame(18, checksum(['5  1 9 5', '7 5 3','2 4 6 8']));
$s = microtime(true);
printf("part1: checksum=%d (in %3f sec)\n", checksum($input), microtime(true)-$s);

function divisibles(array $input): int {
    $sum = 0;
    foreach(toNumbers($input) as $row) {
        foreach($row as $x) {
            foreach($row as $y) {
                if ($x !== $y && is_int($res = $x / $y)) {
                    $sum += $res;
                }
            }
        }
    }
    return $sum;
}
assertSame(9, divisibles(['5 9 2 8', '9 4 7 3','3 8 6 5']));
$s = microtime(true);
printf("part2: divisibles=%d (in %3f sec)\n", divisibles($input), microtime(true)-$s);
