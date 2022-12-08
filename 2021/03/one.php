<?php

$bits = [];
foreach (file($argv[1]) as $line) {
    foreach(str_split(rtrim($line)) as $key => $char) {
        $bits[$key] = array_merge($bits[$key] ?? [], [$char]);
    }
}

$gamma = "";
$epsilon = "";
foreach ($bits as $bit) {
    $values = array_flip(array_count_values($bit));
    ksort($values);
    $gamma .= array_shift($values);
    $epsilon .= array_shift($values);
}

echo bindec($gamma) * bindec($epsilon);
echo PHP_EOL;
