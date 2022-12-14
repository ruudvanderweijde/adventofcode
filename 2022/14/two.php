<?php
const ROCK = '#';
const SAND = 'o';
const ADD_MORE = 'add_more';
const STOP = 'stop';

const DIRECTIONS = ['down' => [1,0], 'downLeft' => [1,-1], 'downRight' => [1,1]];
$entry = [0,500];
$map = [];

foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $in) {
    $path = explode (' -> ', $in);
    $start = array_shift($path);
    while ($next = array_shift($path)) {
        [$x, $y] = explode(',', $start);
        [$_x, $_y] = explode(',', $next);
        for($i=min($x,$_x); $i<=max($x,$_x); ++$i) {
            for($j=min($y,$_y); $j<=max($y,$_y); ++$j) {
              $map[$j][$i] = ROCK;
            }
        }
        $start = $next;
    }
}

// add extra row
$bottomRow = max(array_keys($map)) + 2;
$left = min(array_map('min', array_filter(array_map('array_keys', $map)))) - 153;
$right = max(array_map('max', array_filter(array_map('array_keys', $map)))) + 137;
for($i=$left; $i < $right; ++$i) {
    $map[$bottomRow][$i] = ROCK;
}

function printMap(array $map): void {
    $sand = 0;
    $minX = 0;
    $maxX = max(array_keys($map));
    $minY = min(array_map('min', array_filter(array_map('array_keys', $map))));
    $maxY = max(array_map('max', array_filter(array_map('array_keys', $map))));

    echo PHP_EOL;
    for($i=$minX; $i<=$maxX; ++$i) {
        for($j=$minY; $j<=$maxY; ++$j) {
            $sand += intval(($map[$i][$j] ?? '') === SAND);
            echo $map[$i][$j] ?? '.';
        }
        echo PHP_EOL;
    }
    echo "Sand score: $sand";
    echo PHP_EOL;
}

function addSand(array $map, int $maxDepth): array {
    [$startX, $startY] = [0,500];
    if (($map[1][499] ?? null) && ($map[1][500] ?? null) && ($map[1][501] ?? null)) {
        $map[$startX][$startY] = SAND;
        return [STOP, $map];
    }
    $_x = $startX;
    $_y = $startY;
    $directions = DIRECTIONS;
    while ([$dirX, $dirY] = array_shift($directions)) {
        //printMap($map);
        $nextPos = $map[$__x = ($_x + $dirX)][$__y = ($_y + $dirY)] ?? null;
        if (null === $nextPos) {
            $hasReachedMaxDepth = $_x > $maxDepth;
            if ($hasReachedMaxDepth) {
                return [STOP, $map];
            }
            unset($map[$_x][$_y]);
            $map[$__x][$__y] = SAND;
            $_x = $__x;
            $_y = $__y;

            // reset all directions and try them.
            $directions = DIRECTIONS;
        }
    }

    return [$_x > $maxDepth ? STOP : ADD_MORE, $map];
}

$maxX = max(array_keys($map));
$continue = ADD_MORE;
while ($continue === ADD_MORE) {
    //printMap($map);
    [$continue, $map] = addSand($map, $maxX);
}
printMap($map);
