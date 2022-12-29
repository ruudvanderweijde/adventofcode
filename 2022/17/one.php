<?php

$start = microtime(true);
$debug = 'debug' === ($argv[3] ?? '');
const SPACE = '.';
const ROCK = '#';

$rockCount = 0;
$rocksToProcess = intval(($argv[2] ?? 4000));

$rocksSet = [];
foreach (explode(PHP_EOL.PHP_EOL, file_get_contents('rocks')) as $i => $rawRock) {
    foreach (explode(PHP_EOL, $rawRock) as $y => $rawRockLine) {
        foreach (str_split(rtrim($rawRockLine)) as $x => $char) {
            if ($char === '#') {
                $rocksSet[$i][] = [$y, $x + 2];
            }
        }
    }
}

$grid = [];
$pushesList = str_split(rtrim(file_get_contents($argv[1] ?? 'input-test')));
$pushes = $pushesList;

function printGrid(string $description, array $grid, array $rock): void {
    global $debug;
    if (!$debug) return;

    echo PHP_EOL . $description . PHP_EOL;
    $rockGrid = [];
    foreach ($rock as $coords) {
        $rockGrid[$coords[0]][$coords[1]] = '@';
    }

    foreach($grid as $y => $ys) {
        echo '|';
        foreach($ys as $x => $v) {
            echo $rockGrid[$y][$x] ?? $v;
        }
        echo '|';
        printf('%4d', $y);
        echo PHP_EOL;
    }
    echo '+-------+';
    echo PHP_EOL;
}

$emptyRow = array_fill(0, 7, '.');
$addRock = true;
$rock = [];
$lastHeight = 0;
$heightDiff = [];
while (true) {
    if ($addRock) {
        $addRock = false;
        $rock = $rocksSet[$rockCount % 5];

        if ($rockCount) {
            $newHeight = count($grid);
            $heightDiff[$rockCount] = $newHeight - $lastHeight;
            $lastHeight = $newHeight;
        }

        echo "$rockCount / $rocksToProcess\r";
        if (++$rockCount > $rocksToProcess) {
            break; /* We're done, there are no more rocks! */
        }


        // add lines to grid
        $newLines = count(array_unique(array_column($rock, 0))) + 3;
        $grid = array_merge(array_fill(0, $newLines, $emptyRow), $grid);

        printGrid('Rock begins falling:', $grid, $rock);
        continue;
    }

    // try to move one to left / right
    if (count($pushes) === 0) { $pushes = $pushesList; }
    $push = match(array_shift($pushes)) { '>' => 1, '<' => -1 };
    $canNotPush = array_filter($rock, fn (array $c) => '.' !== ($grid[$c[0]][$c[1]+$push] ?? ''));
    if (count($canNotPush) === 0) {
        $rockBefore = $rock;
        $rock = array_map(fn (array $c) => [$c[0], $c[1]+$push], $rock);
    }
    $description = count($canNotPush) === 0 ? "Jet of gas pushes rock [$push]:" : "Jet of gas pushes rock [$push], but nothing happens:";
    printGrid($description, $grid, $rock);

    $canNotMoveDown = array_filter(
        $rock,
        fn (array $c) => SPACE !== ($grid[$c[0]+1][$c[1]] ?? '')
    );
    if (count($canNotMoveDown) === 0) {
        $rock = array_map(fn (array $c) => [$c[0]+1, $c[1]], $rock);
        printGrid('Rock falls 1 unit:', $grid, $rock);
    } else {
        // we cannot move down, this rock is stuck, add a new one
        foreach ($rock as $c) {
            $grid[$c[0]][$c[1]] = ROCK;
        }
        printGrid('Rock falls 1 unit, causing it to come to rest:', $grid, []);
        $addRock = true;
        // remove empty lines on top of grid
        foreach ($grid as $index => $row) {
            if ($row === $emptyRow) {
                unset($grid[$index]);
                printGrid('Removed top grid line:', $grid, []);
            } else {
                break;
            }
        }
        // remove empty lines on top of grid
        foreach ($grid as $index => $row) {
            if ($row === $emptyRow) {
                unset($grid[$index]);
                printGrid('Removed top grid line:', $grid, []);
            } else {
                break;
            }
        }
    }
}

if ('printGrid' === ($argv[3] ?? '')) {
    $debug = true;
    echo PHP_EOL;
    printGrid('Final grid:', $grid, []);
};
echo PHP_EOL;
echo 'part 1: ' . array_sum(array_slice($heightDiff, 0, 2022));
echo ' (in ' . round(microtime(true)-$start, 3) . ' sec)';
echo PHP_EOL;

[$offset, $length] = getRepeatingSequenceLength($heightDiff, $rocksToProcess);
if ($offset === -1) {
    echo 'failed to find a sequence... please increase the length to find a sequence: > ' . $rocksToProcess;
    echo ' (in ' . round(microtime(true)-$start, 3) . ' sec)';
    echo PHP_EOL;
    exit(3);
}
$numRepeatingRocks = 1000000000000 - $offset;
$repeats = floor($numRepeatingRocks / $length);
$remainder = $numRepeatingRocks % $length;

echo array_sum(array_slice($heightDiff, 0, $offset))
    + $repeats * array_sum(array_slice($heightDiff, $offset, $length))
    + array_sum(array_slice($heightDiff, $offset, $remainder))
;
echo ' (in ' . round(microtime(true)-$start, 3) . ' sec)';
echo PHP_EOL;

function getRepeatingSequenceLength(array $heightDiff, int $max): array {
    for ($length=20; $length < $max / 2; ++$length) {
        echo "$length / " . $max/2 . "\r";
        for ($offset=0; $offset < $max / 2; ++$offset) {
            if (join(array_slice($heightDiff,0+$offset,$length)) === join(array_slice($heightDiff, $length+$offset, $length))) {
                echo PHP_EOL;
                return [$offset, $length];
            }
        }
    }
    return [-1, -1];
};
