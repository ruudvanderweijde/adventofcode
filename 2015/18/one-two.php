<?php
$s = microtime(true);
const DIRS = [[0,1],[0,-1],[1,1],[1,-1],[-1,1],[-1,-1],[1,0],[-1,0]];
$grid = [];
foreach (file($argv[1] ?? 'input-test') as $y => $row) {
    foreach (str_split(rtrim($row)) as $x => $val) {
        $grid[$y][$x] = match($val) { '.' => 0, '#' => 1 };
    }
}
$max = count($grid)-1;
// comment below for part 1
$grid[0][0] = $grid[0][$max] = $grid[$max][0] = $grid[$max][$max] = 1;

$steps = intval($argv[2] ?? 4);
$print = !!($argv[3] ?? false);

for ($i = 0; $i < $steps; $i++) {
    $newGrid = $grid;
    foreach(array_keys($grid) as $y) {
        foreach(array_keys($grid) as $x) {
            $neighbours = array_sum(array_map(fn ($d) => $grid[$y+$d[0]][$x+$d[1]] ?? 0, DIRS));
            if ($grid[$y][$x] === 1 && $neighbours !== 2 && $neighbours !== 3) $newGrid[$y][$x] = 0;
            if ($grid[$y][$x] === 0 && $neighbours === 3) $newGrid[$y][$x] = 1;
        }
    }
    $grid = $newGrid;
    // comment below for part 1
    $grid[0][0] = $grid[0][$max] = $grid[$max][0] = $grid[$max][$max] = 1;
    if ($print) { sleep(1); system('clear'); echo PHP_EOL . "Step: $i" . PHP_EOL; printGrid($grid); }
}

echo array_sum(array_map('array_sum', $grid));
echo ' (in ' . round(microtime(true)-$s, 3) . ' sec)';
echo PHP_EOL;


function printGrid(array $grid): void
{
    $maxY = $maxX = count($grid);

    echo '+' . str_repeat('-', $maxX + 2) . '+' . PHP_EOL;
    for ($y = 0; $y < $maxY; ++$y) {
        echo '| ';
        for ($x = 0; $x < $maxX; ++$x) {
            echo match($grid[$y][$x]) { 0 => '.', 1 => '#' };
        }
        echo ' |';
        printf('%4d', $y);
        echo PHP_EOL;
    }
    echo '+' . str_repeat('-', $maxX + 2) . '+' . PHP_EOL;
}