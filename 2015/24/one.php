<?php

$s = microtime(true);
$input = array_reverse([1, 2, 3, 5, 7, 13, 17, 19, 23, 29, 31, 37, 41, 43, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113]);
$size = intval(($argv[1] ?? 4));

$perGroup = array_sum($input) / $size;
$minSize = $minQuantumEntanglement = PHP_INT_MAX;

function pick($i, $left, $len = 0, $sum = 0, $prod = 1) {
    global $input, $perGroup, $minSize, $minQuantumEntanglement;

    if ($sum == $perGroup) {
        if ($len < $minSize) {
            $minSize = $len;
            $minQuantumEntanglement = $prod;
        } else if ($len == $minSize)
            $minQuantumEntanglement = min($minQuantumEntanglement, $prod);
        return;
    }
    if ($len > $minSize OR $sum > $perGroup OR $left == 0 OR $i >= count($input)) return;

    pick($i+1, $left-1, $len + 1, $sum + $input[$i], $prod * $input[$i]);
    pick($i+1, $left, $len, $sum, $prod);
}

pick(0, floor(count($input)/$size));

printf("quantum entanglement=%d (in %3f sec)\n", $minQuantumEntanglement, microtime(true)-$s);
