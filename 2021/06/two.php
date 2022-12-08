<?php

$filename = $argv[1] ?? 'input-test';
$count = (int) ($argv[2] ?? 80);
$expected = (int) ($argv[3] ?? 0);

assert(preg_match('/^[a-z-]+$/', $filename) && file_exists(__DIR__ . '/' . $filename));
assert($count > 0 && $count < 1000);


$input = array_count_values(explode(',', rtrim(file_get_contents($filename))));
for($i=0;$i<$count; ++$i) {
    $new = [];
    krsort($input);
    foreach ($input as $k => $v) {
        if ($k === 0) {
            $new[8] = $v;
            $new[6] = ($new[6] ?? 0) + $v;
        } else {
            $new[$k-1] = $v;
        }
    }
    $input = $new;
}

echo array_sum($input);
echo PHP_EOL;
