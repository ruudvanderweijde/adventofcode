<?php
function isNice(string $input): bool {
    return preg_match('/(\w{2}).*\1/', $input) && preg_match('/(\w).\1/', $input);
}

$testCases = [['qjhvhtzxzqqjkmpb', true], ['xxyxx', true], ['uurcxstgmygtbstg', false], ['ieodomkazucvgmuy', false]];
foreach($testCases as [$in, $expected]) {
    assert($expected === $actual = isNice($in), "$expected does not match $actual");
}

echo count(array_filter(explode(PHP_EOL, trim(file_get_contents('input'))), 'isNice'));
echo PHP_EOL;
