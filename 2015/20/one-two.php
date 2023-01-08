<?php
$s = microtime(true);

$input = 29000000;
$presents1 = [];
$presents2 = [];

for ($e = 1; $e < $input / 10; $e++) {
    $visits = 0;
    for ($i = $e; $i < $input / 10; $i = $i + $e) {
        $presents1[$i] = ($presents1[$i] ?? 0) + $e * 10;

        if ($visits < 50) {
            $presents2[$i] = ($presents2[$i] ?? 0) + $e * 11;
            $visits = $visits + 1;
        }
    }
}

echo 'Prework done in ' . round(microtime(true)-$s,3) . ' sec' . PHP_EOL;
echo array_key_first(array_filter($presents1, fn (int $item) => $item >= $input)) . ' in ' . round(microtime(true)-$s,3) . ' sec' . PHP_EOL;
echo array_key_first(array_filter($presents2, fn (int $item) => $item >= $input)) . ' in ' . round(microtime(true)-$s,3) . ' sec' . PHP_EOL;
