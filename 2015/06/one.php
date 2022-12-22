<?php
$grid = [];
$size = 999;
for($x=0; $x<=$size; ++$x)
    for($y=0; $y<=$size; ++$y)
        $grid["{$x}:{$y}"] = 0;

/*
 * Input examples
 *  turn off 660,55 through 986,197
 *  turn on 226,196 through 599,390
 *  toggle 322,558 through 977,958
 */
foreach(array_map('trim', file('input')) as $input) {
    if (preg_match('/^(turn off|turn on|toggle) (\d+),(\d+) through (\d+),(\d+)/', $input, $matches)) {
        [, $action, $sx, $sy, $ex, $ey] = $matches;
        for ($_x=min($sx,$ex); $_x<=max($sx,$ex); ++$_x)
            for ($_y=min($sy,$ey); $_y<=max($sy,$ey); ++$_y)
                $grid["{$_x}:{$_y}"] = match($action) {
                    'turn off' => 0,
                    'turn on' => 1,
                    'toggle' => abs($grid["{$_x}:{$_y}"]-1),
                };
    }
}

echo count(array_filter($grid));
echo PHP_EOL;
