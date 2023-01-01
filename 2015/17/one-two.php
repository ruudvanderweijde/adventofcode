<?php
$s = microtime(true);
//$containers = [20,15,10,5,5];
//$target = 25;
$containers = [43,3,4,10,21,44,4,6,47,41,34,17,17,44,36,31,46,9,27,38];
$target = 150;
$count = [];
function listCombinations($numbers, $target, $index = 0, $combination = []) {
    global $count;
    // base case: if the index is at the end of the list, print the combination
    if ($index == count($numbers)) {
        if (array_sum($combination) === $target) {
            $count[count($combination)] = ($count[count($combination)] ?? 0) + 1;
        }
        return;
    }

    // recursive case: try using the current number and not using the current number
    listCombinations($numbers, $target, $index + 1, $combination);
    $combination[] = $numbers[$index];
    listCombinations($numbers, $target, $index + 1, $combination);
}

listCombinations($containers, $target);
ksort($count);
echo 'part1 = ' . array_sum($count);
echo PHP_EOL;
echo 'part2 = ' . current($count);
echo PHP_EOL;
echo ' in (' . round(microtime(true)-$s, 3) . ' sec)' . PHP_EOL;
