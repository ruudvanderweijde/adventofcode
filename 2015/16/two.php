<?php
$sue = [
    'children' => null,
    'cats' => null,
    'samoyeds' => null,
    'pomeranians' => null,
    'akitas' => null,
    'vizslas' => null,
    'goldfish' => null,
    'trees' => null,
    'cars' => null,
    'perfumes' => null,
];

$s = microtime(true);
$sues = [];
foreach (file('input') as $input) {
    # Sample input "Sue 1: cars: 9, akitas: 3, goldfish: 0"
    if (preg_match('/^Sue (\d+): ([a-z]+): (\d+), ([a-z]+): (\d+), ([a-z]+): (\d+)/', $input, $matches)) {
        [,$id,$item1,$val1,$item2,$val2,$item3,$val3] = $matches;

        $sues[intval($id)] = array_filter([
            ...$sue,
            ...[
                $item1 => intval($val1),
                $item2 => intval($val2),
                $item3 => intval($val3),
            ]
        ], 'is_int');
    } else {
        throw new Exception('invalid input: ' . $input);
    }
}

$MFCSAM = [
    'children' => 3,
    'cats' => 7,
    'samoyeds' => 2,
    'pomeranians' => 3,
    'akitas' => 0,
    'vizslas' => 0,
    'goldfish' => 5,
    'trees' => 3,
    'cars' => 2,
    'perfumes' => 1,
];

foreach ($sues as $k => $sue) {
    if (array_key_exists('cats', $sue)) {
        if ($sue['cats'] < $MFCSAM['cats']) continue;
        unset($sue['cats']);
    }
    if (array_key_exists('trees', $sue)) {
        if ($sue['trees'] < $MFCSAM['trees']) continue;
        unset($sue['trees']);
    }
    if (array_key_exists('pomeranians', $sue)) {
        if ($sue['pomeranians'] > $MFCSAM['pomeranians']) continue;
        unset($sue['pomeranians']);
    }
    if (array_key_exists('goldfish', $sue)) {
        if ($sue['goldfish'] > $MFCSAM['goldfish']) continue;
        unset($sue['goldfish']);
    }
    if(count(array_intersect_assoc($MFCSAM, $sue)) === count($sue)) {
        echo $k . ' ';
    }
}
echo ' in (' .round(microtime(true)-$s,5).')' . PHP_EOL;
