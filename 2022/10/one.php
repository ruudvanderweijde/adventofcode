<?php

$filename = $argv[1] ?? 'input-test-large';

$x = 1;
$cycle = [$x];

foreach (array_map('rtrim', file($filename)) as $instruction) {
    $cycle[] = $x;
    if ($instruction !== "noop") {
        $cycle[] = $x += intval(explode(' ', $instruction)[1]);
    }
}

$score = 0;
foreach ($cycle as $k => $v) {
    if (($k+1 + 20) % 40 === 0) {
        $score += ($k+1) * $x;
    }
}
echo $score;
echo PHP_EOL;
