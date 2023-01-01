<?php
const CAP = 'cap';
const DUR = 'dur';
const FLA = 'fla';
const TEX = 'tex';
const CAL = 'cal';

$s = microtime(true);
$ingredients = [];
foreach (file($argv[1] ?? 'input-test') as $item) {
    if (preg_match('/^.+: capacity ([0-9-]+), durability ([0-9-]+), flavor ([0-9-]+), texture ([0-9-]+), calories ([0-9-]+)/', $item, $matches)) {
        [,$cap,$dur,$fla,$tex,$cal] = $matches;
        $ingredients[] = array_map('intval', [CAP=>$cap,DUR=>$dur,FLA=>$fla,TEX=>$tex,CAL=>$cal]);
    }
}

$total = 100;
//$total = 10;
$map = []; // $name, $i, $score
for ($i=0;$i<=100;++$i) {
    foreach ($ingredients as $index => $properties) {
        foreach ($properties as $k => $v) {
            $map[$index][$i][$k] = $v*$i;
        }
    }
}

$result = [];
$combinations = generateCombinations([], $total, count($ingredients));
$best = -INF;
foreach ($combinations as $combination) {
    $score = array_product([
        $cap = max(0, array_sum(array_map(fn($k, $v) => $ingredients[$k][CAP] * $v, array_keys($combination), $combination))),
        $dur = max(0, array_sum(array_map(fn($k, $v) => $ingredients[$k][DUR] * $v, array_keys($combination), $combination))),
        $fla = max(0, array_sum(array_map(fn($k, $v) => $ingredients[$k][FLA] * $v, array_keys($combination), $combination))),
        $tex = max(0, array_sum(array_map(fn($k, $v) => $ingredients[$k][TEX] * $v, array_keys($combination), $combination))),
        $cal = max(0, array_sum(array_map(fn($k, $v) => $ingredients[$k][CAL] * $v, array_keys($combination), $combination))),
    ]);
    $best = max($best, $score);
}

function generateCombinations($combination, $remaining, $num): array {
    if ($num === 0) {
        if ($remaining === 0) {
            return [$combination];
        }
        return [];
    }
    $combinations = [];
    for ($i = 0; $i <= $remaining; $i++) {
        $new_combination = array_merge($combination, [$i]);
        $new_remaining = $remaining - $i;
        $combinations = array_merge($combinations, generateCombinations($new_combination, $new_remaining, $num - 1));
    }
    return $combinations;
}
echo $best . ' in (' .round(microtime(true)-$s,5).')' . PHP_EOL;
