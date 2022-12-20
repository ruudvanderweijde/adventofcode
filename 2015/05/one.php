<?php
function isNice(string $input): bool {
    $vowels = preg_replace('/[^aeiou]/', '', $input);
    $doubleChars = preg_match('/(\w)\1/', $input);
    $forbiddenChars = preg_match('/(ab|cd|pq|xy)/', $input);

    return mb_strlen($vowels) >= 3 && $doubleChars && !$forbiddenChars;
}

$testCases = [['ugknbfddgicrmopn', true], ['aaa', true], ['jchzalrnumimnmhp', false], ['haegwjzuvuyypxyu', false], ['dvszwmarrgswjxmb', false]];
foreach($testCases as [$in, $expected]) {
    assert($expected === $actual = isNice($in), "$expected does not match $actual");
}

echo count(array_filter(explode(PHP_EOL, trim(file_get_contents('input'))), 'isNice'));
echo PHP_EOL;
