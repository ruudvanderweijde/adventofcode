<?php
function temper(string $a): string {
    return sprintf('%s0%s', $a, join(array_map(fn (string $x) => abs(intval($x)+-1), str_split(strrev($a)))));
}
foreach (['1'=>'100','0'=>'001','11111'=>'11111000000','111100001010'=>'1111000010100101011110000'] as $k => $v) { assert($v === temper($k)); }

function checkSum(string $in): string {
    $out = join(array_map(fn(string $chars) => in_array($chars, ['11', '00']) ? '1' : '0', str_split($in, 2)));
    if (strlen($out) % 2 === 0) { $out = checkSum($out); }

    return $out;
}
assert('100' === checkSum('110010110100'));

function fill(string $in, int $max): string {
    while(strlen($in) < $max) { $in = temper($in); }
    return checkSum(substr($in, 0, $max));
}
assert('01100', fill('10000', 20));

$s = microtime(true);
printf("part1: checksum=%s in (%3f seconds)\n", fill('11101000110010100', 272), microtime(true) - $s);

$s = microtime(true);
printf("part2: checksum=%s in (%3f seconds)\n", fill('11101000110010100', 35651584), microtime(true) - $s);
