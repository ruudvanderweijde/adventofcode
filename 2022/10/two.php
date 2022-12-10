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

foreach ($cycle as $i => $x) {
    if ($i % 40 === 0) echo PHP_EOL;
    ++$i;
    $i %= 40;
    if ($i === 0) $i = 40;
    echo in_array($i, [$x, $x+1, $x+2]) ? '#' : '.';
}
echo PHP_EOL;
