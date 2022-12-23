<?php
$filename = $argv[1] ?? 'input';

$map = [];
$totalStringLiterals = 0;
$totalEncoded = 0;
foreach(array_map('rtrim', file($filename)) as $in) {
    $totalStringLiterals += strlen($in);
    $in = str_replace(['"', "'", '\\'], ['11', '11', '\\\\'], $in);
    $totalEncoded += strlen($in) + 2;
}

echo $totalEncoded - $totalStringLiterals;
echo PHP_EOL;
