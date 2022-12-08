<?php

$pos = ['h' => 0, 'd' => 0, 'a' => 0];
foreach (file($argv[1]) as $line) {
    [$move, $size] = explode(' ', rtrim($line));
    switch ($move) {
        case 'forward':
            $pos['h'] += (int) $size;
            $pos['d'] += ($size * $pos['a']);
            break;
        case 'down':
            $pos['a'] += (int) $size;
            break;
        case 'up':
            $pos['a'] -= (int) $size;
            break;
    }
}
echo $pos['h'] * $pos['d'];
echo PHP_EOL;
