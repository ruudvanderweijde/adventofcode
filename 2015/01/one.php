<?php
function getFloor(string $input): int {
    return substr_count($input, '(') - substr_count($input, ')');
}

$testCases = array_map(fn (string $line) => explode(';', $line), file('input-test'));
foreach($testCases as [$in, $expected]) {
    assert(intval(trim($expected)) === $actual = getFloor($in), "$expected does not match $actual");
}

echo getFloor(trim(file_get_contents('input')));
echo PHP_EOL;
