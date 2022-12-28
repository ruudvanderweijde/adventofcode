<?php
$start = microtime(true);
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

    [$time, $location, $score, $opened] = array_pop($queue);
    //echo "$time $where $score\n";

    if (($seen[$time][$location] ?? -1) >= $score) {
        continue;
    }
    $seen[$time][$location] = $score;

    if ($time === 30) {
        $best = max($best, $score);
        continue;
    }

    # if we open the valve here
    if ($flows[$location] > 0 && !($opened[$location] ?? false)) {
        $opened[$location] = true;
        $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
        $queue[] = [$time + 1, $location, $newScore, $opened];
        unset($opened[$location]);
    }

    # if we don't open a valve here
    $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
    foreach ($options[$location] as $option) {
        $queue[] = [$time + 1, $option, $newScore, $opened];
    }
}

echo $best;
echo PHP_EOL;
echo round(microtime(true) - $start, 2) . ' seconds';
echo PHP_EOL;

# 0.08 sec input-test
# 2.26 sec input
