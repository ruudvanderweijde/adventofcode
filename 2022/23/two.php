<?php
const ELF = '#';

const DIRECTIONS = [
    'N'  => [-1,  0],
    'S'  => [ 1,  0],
    'W'  => [ 0, -1],
    'E'  => [ 0,  1],
    'NE' => [-1,  1],
    'NW' => [-1, -1],
    'SE' => [ 1,  1],
    'SW' => [ 1, -1],
];

$actions = [
    [DIRECTIONS['N'], array_map(fn ($d) => DIRECTIONS[$d], ['N', 'NE', 'NW'])],
    [DIRECTIONS['S'], array_map(fn ($d) => DIRECTIONS[$d], ['S', 'SE', 'SW'])],
    [DIRECTIONS['W'], array_map(fn ($d) => DIRECTIONS[$d], ['W', 'NW', 'SW'])],
    [DIRECTIONS['E'], array_map(fn ($d) => DIRECTIONS[$d], ['E', 'NE', 'SE'])],
];

$elves = [];
$moveTo = [];
foreach (array_map('rtrim', explode(PHP_EOL, rtrim(file_get_contents($argv[1] ?? 'input-test')))) as $y => $xs) {
    foreach (str_split($xs) as $x => $v) {
        if ($v === ELF) {
            $elves[] = [$y,$x];
        }
    }
}

function needsToMove(array $pos, array $elves): bool {
    [$y, $x] = $pos;
    foreach (DIRECTIONS as [$_y, $_x]) {
        if (in_array([$y + $_y, $x + $_x], $elves)) {
            return true;
        }
    }
    return false;
}

function getNextPos(array $pos, array $elves, array $actions): array {
    [$y, $x] = $pos;
    foreach ($actions as [$moveTo, $if]) {
        // if XYZ not taken, move to $moveTo
        $ifMoves = array_map(fn (array $p) => [$y + $p[0], $x + $p[1]], $if);
        if (!in_array($ifMoves[0], $elves) && !in_array($ifMoves[1], $elves) && !in_array($ifMoves[2], $elves)) {
            return [$y + $moveTo[0], $x + $moveTo[1]];
        }
    }
    return $pos;
}

$nextPos = [];
$i = 0;
while (++$i) {
    echo "$i\r";
    // elves to move
    $elvesThatNeedsToMove = array_filter($elves, fn (array $pos) => needsToMove($pos, $elves));
    $rawNextPos = array_map(fn (array $pos) => getNextPos($pos, $elves, $actions), $elvesThatNeedsToMove);
    // remove duplicates
    $toRemove = array_keys(array_filter(array_count_values(array_map('json_encode', $rawNextPos)), fn (int $in) => $in > 1));
    $nextPos = array_filter($rawNextPos, fn (array $pos) => !in_array(json_encode($pos), $toRemove));
    if (count($nextPos) === 0) {
        break;
    }
    foreach ($nextPos as $id => $newPos) {
        if (!array_key_exists($id, $elves)) {
            continue;
        }
        //echo sprintf('Elf move: %s -> %s%s', json_encode($elves[$id]), json_encode($newPos), PHP_EOL);
        $elves[$id] = $newPos;
    }
    array_push($actions, array_shift($actions));
    //printGrid($elves);
}

//printGrid($elves);
echo PHP_EOL;
echo $i;
echo PHP_EOL;

function printGrid(array $elves): void {
    $minY = min(array_column($elves, 0));
    $maxY = max(array_column($elves, 0));
    $minX = min(array_column($elves, 1));
    $maxX = max(array_column($elves, 1));

    $overwrites = [];
    foreach ($elves as [$y, $x]) {
        $overwrites[$y][$x] = ELF;
    }

    echo '+'.str_repeat('-',2+$maxX-$minX).'+'.PHP_EOL;
    for($y=$minY; $y<$maxY; ++$y) {
        echo '| ';
        for($x=$minX; $x<$maxX; ++$x) {
            echo $overwrites[$y][$x] ?? '.';
        }
        echo ' |';
        printf('%4d', $y);
        echo PHP_EOL;
    }
    echo '+'.str_repeat('-',2+$maxX-$minX).'+'.PHP_EOL;
}
