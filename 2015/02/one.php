<?php
function getSquareFeet(string $input): int {
    [$l, $w, $h] = $a = array_map('intval', explode('x', $input));
    sort($a, SORT_NUMERIC);
    return 2*$l*$w + 2*$w*$h + 2*$h*$l + $a[0]*$a[1];
}

$testCases = [['2x3x4', 58], ['1x1x10', 43]];
foreach($testCases as [$in, $expected]) {
    assert($expected === $actual = getSquareFeet($in), "$expected does not match $actual");
}

echo array_sum(array_map('getSquareFeet', explode(PHP_EOL, trim(file_get_contents('input')))));
echo PHP_EOL;
