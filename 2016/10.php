<?php
enum Type: string { case INPUT = 'bot'; case OUTPUT = 'output'; }

$s = microtime(true);
$input = file('10.input', FILE_IGNORE_NEW_LINES);

$dict = $bots = $queue = [];
foreach ($input as $instruction) {
    if (preg_match('/bot (\d+) gives low to (bot|output) (\d+) and high to (bot|output) (\d+)/', $instruction, $matches)) {
        [,$id, $lowType, $lowId, $highType, $highId] = $matches;
        $dict[intval($id)] = [Type::from($lowType), intval($lowId), Type::from($highType), intval($highId)];
    } elseif (preg_match('/value (\d+) goes to bot (\d+)/', $instruction, $matches)) {
        [,$value, $id] = array_map('intval', $matches);
        $bots[$id][Type::INPUT->name][] = $value;
        if (count($bots[$id][Type::INPUT->name]) === 2) {
            $queue = [$id];
        }
    }
};

while(count($queue) > 0) {
    $target = array_shift($queue);

    $values = $bots[$target][Type::INPUT->name] ?? [];
    if (count($values) !== 2) { continue; }

    $bots[$target][Type::INPUT->name] = [];
    sort($values, SORT_NUMERIC);
    [$low, $high] = $values;
    if ($low === 17 && $high === 61) {
        printf("part1: bot=%d in (%3f seconds)\n", $target, microtime(true) - $s);
    }
    [$lowType, $lowId, $highType, $highId] = $dict[$target];
    $bots[$lowId][$lowType->name][] = $low;
    $bots[$highId][$highType->name][] = $high;
    array_push($queue, $lowId, $highId);
}
$res = array_product([
    $zero = array_sum($bots[0][Type::OUTPUT->name] ?? []),
    $one  = array_sum($bots[1][Type::OUTPUT->name] ?? []),
    $two  = array_sum($bots[2][Type::OUTPUT->name] ?? []),
]);
printf("part2: score=(%dx%dx%d)=%d in (%3f seconds)\n", $zero, $one, $two, $res, microtime(true) - $s);