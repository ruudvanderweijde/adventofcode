<?php

$grid = array_map(
    fn (string $line) => array_map('intval', explode(',', $line)),
    explode(PHP_EOL, rtrim(file_get_contents($argv[1] ?? 'input-test')))
);

$totalCount = 0;
foreach ($grid as [$x, $y, $z]) {
    $count = 6;
    foreach ([[-1,0,0],[1,0,0],[0,-1,0],[0,1,0],[0,0,-1],[0,0,1]] as [$_x, $_y, $_z]) {
        if (in_array([$x+$_x,$y+$_y,$z+$_z], $grid)) {
            --$count;
        };
    }
    $totalCount += $count;
}
var_dump($totalCount);
