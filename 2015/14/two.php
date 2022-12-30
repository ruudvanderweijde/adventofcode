<?php
$s = microtime(true);
$reindeer = [];
foreach (file($argv[1] ?? 'input') as $item) {
    if (preg_match('/^([A-Z][a-z]+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds./', $item, $matches)) {
        [,$name,$speed,$duration,$rest] = $matches;
        $reindeer[] = [$name, intval($speed), intval($duration), intval($rest)];
    }
}


$max = 2503;
$distances = [];
$points = [];
for ($i=0; $i<=$max; ++$i) {
    foreach ($reindeer as $r) {
        [$name,$speed,$duration,$rest] = $r;

        $distance = $distances[$name] ?? 0;

        $cycle = $duration + $rest;
        $leftover = $i % $cycle;
        $distance += $leftover < $duration ? $speed : 0;
        $distances[$name] = $distance;
    }

    // add 1 to the leading reindeers
    $highest = max($distances);
    foreach ($reindeer as $r) {
        [$name] = $r;
        $points[$name] = ($points[$name] ?? 0) + ($distances[$name] === $highest ? 1 : 0);
    }
}

echo max($points) . ' in (' .round(microtime(true)-$s,5).')' . PHP_EOL;
