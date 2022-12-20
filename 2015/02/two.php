<?php
function getRibbon(string $input): int {
    [$l, $w, $h] = $a = array_map('intval', explode('x', $input));
    sort($a, SORT_NUMERIC);
    return $l*$w*$h + $a[0]+$a[0]+$a[1]+$a[1];
}

$testCases = [['2x3x4', 34], ['1x1x10', 14]];
foreach($testCases as [$in, $expected]) {
    assert($expected === $actual = getRibbon($in), "$expected does not match $actual");
}

echo array_sum(array_map('getRibbon', explode(PHP_EOL, trim(file_get_contents('input')))));
echo PHP_EOL;
