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
$queue = [[1, "AA", "AA", 0, []]];
$seen = [];
$maxFlow = array_sum($flows);
while (count($queue) > 0) {

    [$time, $location, $elephant, $score, $opened] = array_pop($queue);
    //echo "$time $where $score\n";

    if (($seen[$time][$location][$elephant] ?? -1) >= $score) {
        continue;
    }
    $seen[$time][$location][$elephant] = $score;

    if ($time === 26) {
        $best = max($best, $score);
        continue;
    }

    # optimization: if all valves are working, do nothing
    # with a friend this will happen...
    $currentFlow = array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
    if ($currentFlow >= $maxFlow) {
        $newScore = $score + $currentFlow;
        while ($time < 25) {
            $time += 1;
            $newScore += $currentFlow;
            $queue[] = [$time + 1, $location, $elephant, $newScore, $opened];
        }
        continue;
    }

    # case 1: we open a valve here
    if ($flows[$location] > 0 && !($opened[$location] ?? false)) {
        $opened[$location] = true;

        # case 1A: and the elephant open its valve too!
        if ($flows[$elephant] > 0 && !($opened[$elephant] ?? false)) {
            $opened[$elephant] = true;
            $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
            $queue[] = [$time + 1, $location, $elephant, $newScore, $opened];
            unset($opened[$elephant]);
        }
        # case 1B: the elephant goes somewhere
        $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
        foreach ($options[$elephant] as $option) {
            $queue[] = [$time + 1, $location, $option, $newScore, $opened];
        }
        $opened[$location] = false;
    }

    # case 2: we go somewhere else
    foreach ($options[$location] as $option) {

        # case 2A: and the elephant open its valve!
        if ($flows[$elephant] > 0 && !($opened[$elephant] ?? false)) {
            $opened[$elephant] = true;
            $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
            $queue[] = [$time + 1, $option, $elephant, $newScore, $opened];
            unset($opened[$elephant]);
        }

        # case 2B: and the elephant goes somewhere
        $newScore = $score + array_sum(array_filter($flows, fn($key) => $opened[$key] ?? false, ARRAY_FILTER_USE_KEY));
        foreach ($options[$elephant] as $_option) {
            $queue[] = [$time + 1, $option, $_option, $newScore, $opened];
        }
    }
}

echo $best;
echo PHP_EOL;
echo round(microtime(true) - $start, 2) . ' seconds';
echo PHP_EOL;

# 0.08 sec input-test
# 2.26 sec input
