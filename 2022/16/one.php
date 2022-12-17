<?php

$in = file($argv[1] ?? 'input-test');
$options = [];
$flows = [];
foreach ($in as $line) {
    if (preg_match('/Valve (\w+) has flow rate=(\d+); tunnels? leads? to valves? (.*)/', $line, $m)) {
        $flows[$m[1]] = intval($m[2]);
        $options[$m[1]] = explode(', ', trim($m[3]));
    }
}

$best = 0;
$queue = [[1, "AA", 0, []]];
$seen = [];
while (count($queue) > 0) {

    [$time, $where, $score, $opened] = array_pop($queue);

    if (($seen[$time][$where] ?? -1) >= $score) {
        continue;
    }
    $seen[$time][$where] = $score;

    if ($time === 30) {
        $best = max($best, $score);
        continue;
    }

    # if we open the valve here
    if ($flows[$where] > 0 && !($opened[$where] ?? false)) {
        $opened[$where] = true;
        $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
        $queue[] = [$time + 1, $where, $newScore, $opened];
        unset($opened[$where]);
    }

    # if we don't open a valve here
    $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
    foreach ($options[$where] as $option) {
        $queue[] = [$time + 1, $option, $newScore, $opened];
    }
}

echo $best;
echo PHP_EOL;
