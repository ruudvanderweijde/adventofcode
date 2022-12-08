<?php

$pos = ['h' => 0, 'd' => 0];
foreach (file($argv[1]) as $line) {
    [$move, $size] = explode(' ', rtrim($line));
    switch ($move) {
        case 'forward':
            $pos['h'] += (int) $size;
            break;
        case 'down':
            $pos['d'] += (int) $size;
            break;
        case 'up':
            $pos['d'] -= (int) $size;
            break;
    }
}
echo $pos['h'] * $pos['d'];
echo PHP_EOL;
