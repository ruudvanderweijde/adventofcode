<?php
$s = microtime(true);
$stress = []; // [$from][$to] = $val;
foreach (file($argv[1] ?? 'input') as $item) {
    if (preg_match('/^([A-Z][a-z]+) would (gain|lose) (\d+) happiness units by sitting next to ([A-Z][a-z]+)\./', $item, $matches)) {
        [,$from,$op,$value,$to] = $matches;
        $stress[$from][$to] = match($op) { 'gain' => $value * 1, 'lose' => $value * -1 };
    }
}
$names = array_unique(array_keys($stress));

$totals = [];
foreach (getPermutations($names) as $list) {
    $size = count($list);
    $total = 0;
    for ($i=0; $i<$size; ++$i) {
        $person = $list[$i];
        $left = $i==0 ? $size-1 : $i-1;
        $right = $i==$size-1 ? 0 : $i+1;
        $total += $stress[$person][$list[$left]]; // left
        $total += $stress[$person][$list[$right]]; // right
    }
    $totals[] = $total;
}

echo max($totals) . ' in (' .round(microtime(true)-$s,5).')' . PHP_EOL;

function getPermutations($items, $perms = []): array {
    if (empty($items)) return [$perms];
    $ret = [];
    for ($i = count($items) - 1; $i >= 0; --$i) {
        $newItems = $items;
        $newPerms = $perms;
        [$foo] = array_splice($newItems, $i, 1);
        array_unshift($newPerms, $foo);
        $ret = array_merge($ret, getPermutations($newItems, $newPerms));
    }
    return $ret;
}