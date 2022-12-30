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
foreach ($reindeer as $r) {
    [$name,$speed,$duration,$rest] = $r;
    $cycle = $duration + $rest;
    $distance = $speed * $duration * floor($max / $cycle);
    $leftover = $max % $cycle;
    $distance += $speed * min($leftover, $duration);
    $distances[$name] = $distance;
}

echo max($distances) . ' in (' .round(microtime(true)-$s,5).')' . PHP_EOL;
