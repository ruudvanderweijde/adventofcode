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

function printMap(array $map): void {
    $sand = 0;
    $minX = min(array_keys($map));
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
    if ($map[$startX][$startY] ?? null) {
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

/*
....................................................
....................................................
....................................................
....................................................
....................................................
....................................................
....................................................
................oo..................................
...............oooo.................................
..............oooooo................................
.............oooooooo...............................
............oooooooooo..............................
...........ooooooooooo#.............................
..........#############.............................
......................oo............................
.....................oooo...........................
....................######..........................
..........................o.........................
.........................ooo........................
.................######.######......................
.......................o............................
......................ooo...........................
..............######.######.######..................
....................o...............................
...................ooo..............................
..................ooooo.............................
.................ooooooo............................
................#oooooooo.....#.....................
...............o###############.....................
..............ooo...................................
.............ooooo..................................
............######o.................................
...........o.....ooo................................
..........ooo...ooooo...............................
.........######o######..............................
........o.....ooo...................................
.......ooo...ooooo..................................
......######o######.######..........................
...........ooo......................................
..........ooooo.....................................
.........ooooooo.....#..............................
.......###############..............................
....oo..............................................
...oooo.............................................
..#ooo#o............................................
..#ooo#oo...........................................
###ooo####..........................................
#.ooooo..#..........................................
#ooooooo.#..........................................
#oooooooo#..........................................
#oooooooo#..........................................
#oooooooo#..........................................
#oooooooo#..........................................
##########..........................................
....................................................
....................................................
....................................................
......#.............................................
......#..o#.........................................
......#.oo#.........................................
......#o#o#o........................................
......#o#o#oo.......................................
......#o#o#ooo......................................
......#o#o#o#oo.....................................
......#o#o#o#ooo....................................
......#o#o#o#oooo...................................
......#######ooooo..................................
............ooooooo.................................
...........ooooooooo................................
..........oooooo#ooo#...............................
.........o#ooooo#ooo#...............................
......#.oo#ooooo#ooo#...............................
......#ooo#ooooo#ooo#...............................
......#ooo#ooooo#ooo#...............................
....#.#ooo#ooo#o#ooo#...............................
....#.#o#o#o#o#o#ooo#...............................
....#.#o#o#o#o#o#ooo#...............................
....#.#o#o#o#o#o#o#o#...............................
....#.#o#o#o#o#o#o#o#...............................
....#################...............................
....................oo..............................
...................oooo.............................
.................#ooooo#............................
.................#ooooo#............................
.................#ooo#o#............................
.................#ooo#o#o...........................
.................#ooo#o#oo..........................
.................#ooo#o#ooo.........................
.................#ooo#o#oooo........................
.................#o#o#o#ooooo.......................
.................#o#o#o#oooooo......................
.................#o#o#o#ooooooo.....................
.................#######oooooooo....................
.......................oooooooooo...................
......................oooooooooooo..................
.....................######oooooooo.................
..........................oooooooooo................
..................######.######oooooo...............
..............................oooooooo..............
...............######.######.######oooo.............
..................................oooooo............
............######.######.######.######oo...........
......................................oooo..........
.........######.######.######.######.######.........
...........................................o........
..........................................ooo.......
.........................................#ooo#......
.........................................#ooo#......
.........................................#ooo#......
........................................o#ooo#......
.......................................###ooo#######
.......................................#.ooooo.....#
......................................o#ooooooo....#
.....................................oo#oooooooo...#
....................................ooo#ooooooooo..#
...................................oooo#oooooooooo.#
..................................ooooo#ooooooooooo#
.................................oooooo#############
................................oooooooo............
...............................oooooooooo...........
..............................oooooo#####o..........
.............................oooooooo...ooo.........
............................ooooo#####.#####........
...........................ooooooo..................
..........................oooo#####.#####.#####.....
.........................oooooo.....................
........................ooo#####.#####.#####.#####..
.......................ooooo........................
......................ooooooo.......................
.....................oo#oooo#o......................
....................ooo#oooo#oo.....................
...................#####oooo######..................
...................#...oooooo....#..................
...................#..oooooooo...#..................
...................#.oooooooooo..#..................
...................#oooooooooooo.#..................
...................###############..................
.................oo.................................
................oooo................................
...............#oooo#...............................
...............#oooo#...............................
..........######oooo##..............................
..........#....oooooo#..............................
..........#...ooooooo#..............................
..........#..oooooooo#..............................
..........#.ooooooooo#..............................
..........#oooooooooo#..............................
..........#oooooooooo#..............................
..........#oooooooooo#..............................
..........############..............................
....................................................
.....................oo.............................
....................oooo............................
..................#oooooo...........................
..................#######o..........................
........................ooo.........................
.......................ooooo........................
...............#......ooooooo.......................
...............#.....oo#oooooo......................
...............#....o#o#ooooooo.....................
...............#...oo#o#ooooooo#....................
...............#.#ooo#o#ooooooo#....................
...............#.#o#o#o#o#o#ooo#....................
...............#.#o#o#o#o#o#ooo#....................
...............#.#o#o#o#o#o#ooo#....................
...............#.#o#o#o#o#o#ooo#o...................
...............#.#o#o#o#o#o#o#o#o#..................
...............###################..................
..................................o.................
Sand score: 893
 */
