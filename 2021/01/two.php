<?php

$count = 0;
$prev=null;
$file = file($argv[1]);
foreach($file as $index => $item) {
    $sum = ((int) rtrim($file[$index]))
        + ((int) rtrim($file[$index+1] ?? "0"))
        + ((int) rtrim($file[$index+2] ?? "0"));
    if ($prev && $sum > $prev) {
        ++$count;
    }
    $prev = $sum;
}
echo $count;
echo PHP_EOL;
