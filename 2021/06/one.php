<?php

$filename = $argv[1];
$count = (int) $argv[2];
$expected = (int) ($argv[3] ?? 0);

assert(preg_match('/^[a-z-]+$/', $filename) && file_exists(__DIR__ . '/' . $filename));
assert($count > 0 && $count < 1000);

$input = array_map('intval', explode(',', rtrim(file_get_contents($filename))));
for($i=0;$i<$count; ++$i) {
    foreach(array_filter($input, fn(int $i) => $i === 0) as $pop) {
        array_push($input, 9);
    }
    $input = array_map(fn(int $i) => $i === 0 ? 6 : --$i, $input);
}

$score = count($input);

if ($expected) {
    assert($expected === $score, sprintf('Expected %s, got [%d] instead.', $expected, $score));
    echo 'Test passed!' . PHP_EOL;
}

echo $score;
echo PHP_EOL;
