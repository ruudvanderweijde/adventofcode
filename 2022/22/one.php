<?php
const OPEN = '.';
const WALL = '#';

const ROTATE_LEFT = 'L';
const ROTATE_RIGHT = 'R';

CONST DIRECTION_RIGHT = 0;
CONST DIRECTION_DOWN = 1;
CONST DIRECTION_LEFT = 2;
CONST DIRECTION_UP = 3;

const DIRECTIONS = [
    DIRECTION_RIGHT => [ 0, 1],
    DIRECTION_DOWN  => [ 1, 0],
    DIRECTION_LEFT  => [ 0,-1],
    DIRECTION_UP    => [-1, 0],
];

[$rawGrid, $rawInstructions] = array_map('rtrim', explode(PHP_EOL.PHP_EOL, rtrim(file_get_contents($argv[1] ?? 'input-test'))));

$grid = [];
$trail = [];
foreach (explode(PHP_EOL, $rawGrid) as $y => $xs) {
    foreach (str_split($xs) as $x => $v) {
        if (in_array($v, [OPEN, WALL])) {
            $grid[$y][$x] = $v;
        }
    }
}

function printGrid(array $grid, array $trail): void {
    $maxX = max(array_map('max', array_map('array_keys', $grid)));
    $maxY = count($grid);

    foreach ($trail as [$y, $x, $char]) {
        $grid[$y][$x] = $char;
    }

    echo "Last pos: [y=$y,x=$x]\n";
    echo '+'.str_repeat('-',$maxX+2).'+'.PHP_EOL;
    for($y=0; $y<$maxY; ++$y) {
        echo '| ';
        for($x=0; $x<$maxX; ++$x) {
            echo $grid[$y][$x] ?? ' ';
        }
        echo ' |';
        printf('%4d', $y);
        echo PHP_EOL;
    }
    echo '+'.str_repeat('-',$maxX+2).'+'.PHP_EOL;
}

function printDirection(int $direction): string {
    return match ($direction) {
        DIRECTION_RIGHT => '>',
        DIRECTION_DOWN => 'v',
        DIRECTION_LEFT => '<',
        DIRECTION_UP => '^',
    };
}

$pos = [0, min(array_keys($grid[0]))];
$direction = DIRECTION_RIGHT;

if (!preg_match_all('/\d+|[LR]/', $rawInstructions, $matches)) { throw new Exception('Failed to parse instructions'); }
$instructions = $matches[0];
while ($instruction = array_shift($instructions)) {
    //echo "READING INSTRUCTION: $instruction\n";
    if (ROTATE_RIGHT === $instruction) {
        $direction = $direction === DIRECTION_UP ? DIRECTION_RIGHT : $direction + 1;
    } elseif (ROTATE_LEFT === $instruction) {
        $direction = $direction === DIRECTION_RIGHT ? DIRECTION_UP : $direction - 1;
    } else {
        for($i=0; $i<intval($instruction); ++$i) {
            // try to move
            [$y, $x] = $pos;
            $trail[] = [$y, $x, printDirection($direction)];
            [$_y, $_x] = DIRECTIONS[$direction];
            $nextY = $y + $_y;
            $nextX = $x + $_x;
            $nextPos = $grid[$nextY][$nextX] ?? null;
            if ($nextPos === null) {
                if ($direction === DIRECTION_RIGHT) {
                    $nextX = min(array_keys($grid[$y]));
                } elseif ($direction === DIRECTION_DOWN) {
                    $nextY = min(array_filter(array_keys($grid), fn (int $key) => $grid[$key][$x] ?? false));
                } elseif ($direction === DIRECTION_LEFT) {
                    $nextX = max(array_keys($grid[$y]));
                } elseif ($direction === DIRECTION_UP) {
                    $nextY = max(array_filter(array_keys($grid), fn (int $key) => $grid[$key][$x] ?? false));
                }
                $nextPos = $grid[$nextY][$nextX];
            }
            if ($nextPos === WALL) {
                break; // stop moving
            }
            $pos = [$nextY, $nextX];
        }
    }
}

[$y, $x] = $pos;
echo (1000*(1+$y)) + (4*(1+$x)) + $direction;
echo PHP_EOL;

// echo join(' -> ', $matches[0]) . PHP_EOL;
printGrid($grid, $trail);
