<?php
$filename = $argv[1] ?? 'input';

$map = [];
$totalStringLiterals = 0;
$totalMemory = 0;
foreach(array_map('rtrim', file($filename)) as $in) {
    $totalStringLiterals += strlen($in);
    $in = str_replace(['\\\\', '\"', "\'"], '1', $in);
    $in = preg_replace('/\\\\x[0-9a-f]{2}/', '1', $in);
    $totalMemory += strlen($in) - 2;
}

echo $totalStringLiterals - $totalMemory;
echo PHP_EOL;
