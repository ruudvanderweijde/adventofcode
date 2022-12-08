<?php
$count = 0;
foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $line) {
    $signs = explode(' ', explode(' | ', $line)[1]);
    foreach($signs as $sign) {
        if (in_array(strlen($sign), [2,3,4,7])) {
            ++$count;
        }
    }
}
echo $count;
echo PHP_EOL;
