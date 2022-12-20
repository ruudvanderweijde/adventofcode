<?php
$debug = $argv[2] ?? false;

const KEY = 811589153;
$input = array_map(fn (string $line) => intval($line), explode(PHP_EOL, rtrim(file_get_contents($argv[1] ?? 'input-test'))));
$map = array_map(fn (string $k, string $v): array => [intval($k), intval($v)*KEY], array_keys($input), array_values($input));

$min = 0;
$max = count($input)-1;

function printMap(array $map) {
    $map = sortMap($map);
    echo join("\t", array_map(fn (array $i) => $i[1], $map));
    echo PHP_EOL;
    echo join("\t", array_map(fn (array $i) => $i[0], $map));
    echo PHP_EOL;
    echo PHP_EOL;
}

function sortMap(array $map): array {
    usort($map, function ($a, $b) { return $a[0] <=> $b[0]; });
    return $map;
}

if ($debug) echo "Initial arragement\n";
if ($debug) printMap($map);
for ($i=0; $i<10; ++$i) {
    foreach ($input as $initialPos => $item) {
        [$oldPos, $value] = $map[$initialPos];

        if ($value === 0) { continue; }

        $newPos = $oldPos + ($value % $max);
        $direction = $value > 0 ? -1 : 1;

        if ($newPos <= $min) {
            $newPos = $max + $newPos;
            $direction *= -1;
        }
        if ($newPos > $max) {
            $newPos = $newPos - $max;
            $direction *= -1;
        }

        if ($debug) echo "Moving [$value] from pos [$oldPos] to [$newPos]\n";
        $map = array_map(fn ($i) => $i[0] >= min($oldPos, $newPos) && $i[0] <= max($oldPos, $newPos) ? [$i[0]+=$direction, $i[1]] : $i, $map);
        $map[$initialPos] = [$newPos, $value];
        if ($debug) printMap($map);
    }
}

$sortedList = array_map(fn ($x) => $x[1], sortMap($map));
$locateZero = array_search('0', $sortedList);
$fullList = array_slice($sortedList, $locateZero);
while (count($fullList) < 3000) {
    $fullList = array_merge($fullList, $sortedList);
}

echo array_sum([
    $fullList[1000],
    $fullList[2000],
    $fullList[3000],
]);
echo PHP_EOL;
