<?php
require_once('../lib/partEnum.php');

function sortString(string $in): string {
    $chars = str_split($in);
    sort($chars);
    return implode($chars);
}

function passphrase(string $in): bool {
    global $part;
    $values = explode(' ', $in);
    if ($part === Part::TWO) {
        $values = array_map('sortString', $values);
    }
    return count($values) === count(array_unique($values));
}

assert(true === passphrase('aa bb cc dd ee'));
assert(false === passphrase('aa bb cc dd aa'));
assert(true === passphrase('aa bb cc dd aaa'));

$part = Part::ONE;
$input = file('04.input', FILE_IGNORE_NEW_LINES);
$s = microtime(true);
printf("part1: count=%d (in %3f sec)\n", count(array_filter($input, 'passphrase')), microtime(true)-$s);

$part = Part::TWO;
$s = microtime(true);
printf("part2: count=%d (in %3f sec)\n", count(array_filter($input, 'passphrase')), microtime(true)-$s);
