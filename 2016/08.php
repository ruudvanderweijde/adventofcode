<?php

$input = file('08.input', FILE_IGNORE_NEW_LINES);
$testInput = ['rect 3x2', 'rotate column x=1 by 1', 'rotate row y=0 by 4', 'rotate column x=1 by 1'];

function screen(array $instructions): array {
    $width = 50;
    $height = 6;
    $screen = array_map(fn ($x) => array_fill(0,$width,0), range(1,$height));
    foreach ($instructions as $instruction) {
        $newScreen = $screen;
        if (preg_match('/rect (\d+)x(\d+)/', $instruction, $matches)) {
            [,$x,$y] = $matches;
            for($i=0;$i<intval($y);$i++) {
                for($j=0;$j<intval($x);$j++) {
                    $newScreen[$i][$j] = 1;
                }
            }
        } elseif (preg_match('/rotate row y=(\d+) by (\d+)/', $instruction, $matches)) {
            [,$y,$count] = $matches;
            for($i=0;$i<$width;$i++) {
                $newScreen[$y][($i+intval($count))%$width] = $screen[$y][$i];
            }
        } elseif (preg_match('/rotate column x=(\d+) by (\d+)/', $instruction, $matches)) {
            [,$x,$count] = $matches;
            for($i=0;$i<$height;$i++) {
                $newScreen[($i+intval($count))%$height][$x] = $screen[$i][$x];
            }
        }
        $screen = $newScreen;
    }
    return $screen;
}

function printScreen(array $grid) { echo PHP_EOL; foreach($grid as $ys) { foreach($ys as $v) { echo $v === 1 ? '#' : '.'; } echo PHP_EOL; } }

# part 1
$s = microtime(true);
$screen = screen($input);
printf("part1: count=%d in (%3f seconds)\n", array_sum(array_map('array_sum', $screen)), microtime(true) - $s);

# part 2
printScreen($screen);