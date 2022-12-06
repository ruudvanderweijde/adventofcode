<?php

$filename = $argv[1];
$expected = (int) ($argv[2] ?? 0);

$input = str_split(rtrim(file_get_contents($filename)));
$unique = false;
$char = 0;

do {
    if (4 === count(array_unique(array_slice($input, $char+0, 4)))) {
        $unique = true;
    }
    if (++$char > count($input)) {
        throw new Exception('No result');
    }
}
while (!$unique);

$score = $char + 3;

if ($expected) {
    assert($expected === $score, sprintf('Expected %s, got [%d] instead.', $expected, $score));
    echo 'Test passed!' . PHP_EOL;
}

echo $score . PHP_EOL;
