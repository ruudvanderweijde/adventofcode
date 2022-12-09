<?php

$filename = $argv[1] ?? 'input-test';

$headY = $headX = 0;
$tailX = $tailY = 0;
$trail = [];

foreach (array_map('rtrim', file($filename)) as $instruction) {
    [$direction, $count] = explode(' ', $instruction);
    $x = match($direction) { 'L' => -1, 'R' => 1, 'U', 'D' => 0 };
    $y = match($direction) { 'L', 'R' => 0, 'U' => 1, 'D' => -1 };

    //echo "$instruction\n";
    for($i=0; $i<$count; ++$i) {
        $headX += $x;
        $headY += $y;

        if (abs($headX - $tailX) > 1 || abs($headY - $tailY) > 1) {
            $tailX = match($direction) { 'L' => $headX+1, 'R' => $headX-1, 'U', 'D' => $headX };
            $tailY = match($direction) { 'L', 'R' => $headY, 'U' => $headY-1, 'D' => $headY+1 };
        }
        $trail["{$tailX}_{$tailY}"] = 1;
        //echo " > H [$headX,$headY] \t T [$tailX,$tailY]\n";
    }
}

echo count($trail);
echo PHP_EOL;
