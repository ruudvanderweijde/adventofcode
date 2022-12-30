<?php
$s = microtime(true);
$input = file_get_contents('input');

// part one
echo array_sum(array_filter(explode(',', preg_replace('/[^0-9-]+/', ',', $input))))
    . ' in ('.round(microtime(true)-$s,5).')'
    . PHP_EOL;

// part two
$json = json_decode($input);
function sum(array|object $in): int {
    $sum = 0;
    if (is_object($in)) {
        $in = get_object_vars($in);
        if (in_array('red', $in)) return 0;
    }
    foreach ($in as $child) {
        if (is_int($child)) { $sum += $child; }
        elseif (is_object($child) || is_array($child)) { $sum += sum($child); }
    }
    return $sum;
}

function check(int $expected, int $actual) {
    assert($expected === $actual, "Expected [$expected] does not equal actual [$actual]");
}
check(6, sum([1,2,3]));
check(4, sum(json_decode('[1,{"c":"red","b":2},3]')));
check(0, sum(json_decode('{"d":"red","e":[1,2,3,4],"f":5}')));
check(6, sum([1,"red",5]));

echo sum($json)
    . ' in ('.round(microtime(true)-$s,5).')'
    . PHP_EOL;