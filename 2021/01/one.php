<?php

$count = 0;
$prev=null;
foreach(file($argv[1]) as $item) {
    $item = (int) rtrim($item);
    if ($prev && $item > $prev) {
        ++$count;
    }
    $prev = $item;
}
echo $count;
echo PHP_EOL;
