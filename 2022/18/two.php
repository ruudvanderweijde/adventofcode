<?php
unset($_SERVER);

$start = microtime(true);
$grid = explode(PHP_EOL, rtrim(file_get_contents($argv[1] ?? 'input-test')));
unset($argv);

$min = INF;
$max = -INF;

foreach($grid as $cube) {
    [$x, $y, $z] = array_map('intval', explode(',', $cube));
    $min = min($min, $x, $y, $z);
    $max = max($max, $x, $y, $z);
}
unset($cube);

function countAffectedCubes(array $grid, int $x, int $y, int $z): int {
    $count = 0;
    if (in_array($x+1 .",$y,$z",    $grid)) $count++;
    if (in_array($x-1 .",$y,$z",    $grid)) $count++;
    if (in_array("$x,".$y+1 .",$z", $grid)) $count++;
    if (in_array("$x,".$y-1 .",$z", $grid)) $count++;
    if (in_array("$x,$y,".$z+1,     $grid)) $count++;
    if (in_array("$x,$y,".$z-1,     $grid)) $count++;

    return $count;
};

$visited = [];

$surfaceArea = 0;
$queue = [[0,0,0]];

while (count($queue) > 0) {
    [ $x, $y, $z ] = array_shift($queue);
    if (in_array("$x,$y,$z", $visited)) continue;
    if (in_array("$x,$y,$z", $grid)) continue;
    if ($x < $min - 1 || $y < $min - 1 || $z < $min - 1) continue;
    if ($x > $max + 1 || $y > $max + 1 || $z > $max + 1) continue;
    $visited[] = "$x,$y,$z";

    $surfaceArea += countAffectedCubes($grid, $x, $y, $z);

    array_push(
        $queue,
        [$x+1,$y,$z],
        [$x-1,$y,$z],
        [$x,$y+1,$z],
        [$x,$y-1,$z],
        [$x,$y,$z+1],
        [$x,$y,$z-1],
    );
}

echo $surfaceArea;
echo ' (in ' . round(microtime(true)-$start, 3) . ' sec)';
echo PHP_EOL;
