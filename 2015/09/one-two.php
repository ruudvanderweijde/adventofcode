<?php

$map = [];
foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $input) {
    if (preg_match('/(\w+) to (\w+) = (\d+)/', $input, $matches)) {
        [, $from, $to, $cost] = $matches;
        $map[$from][$to] = $map[$to][$from] = intval($cost);
    } else {
        throw new Exception('Failed to parse: ' . $input);
    }
}

function getPermutations($items, $perms = []): array {
    $ret = [];
    if (empty($items)) {
        $ret[] = $perms;
    }  else {
        for ($i = count($items) - 1; $i >= 0; --$i) {
            $newItems = $items;
            $newPerms = $perms;
            list($foo) = array_splice($newItems, $i, 1);
            array_unshift($newPerms, $foo);
            $ret = array_merge($ret, getPermutations($newItems, $newPerms));
        }
    }
    return $ret;
}
$routes = getPermutations(array_keys($map));
$lengths = [];
foreach ($routes as $k => $route) {
    $length = 0;
    for ($i=0; $i < count($route)-1; ++$i) {
        $length += $map[$route[$i]][$route[$i+1]];
    }
    $lengths[join(' -> ', $route)] = $length;
}

echo min($lengths);
echo PHP_EOL;
echo max($lengths);
echo PHP_EOL;
