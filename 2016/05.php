<?php

function firstDoor(string $input): string
{
    $password = '';
    $i = -1;
    while (strlen($password) < 8) {
        $md5 = md5($input . ++$i);
        if (str_starts_with($md5, '00000')) {
            $password .= $md5[5];
        }
    }
    return $password;
}

function secondDoor(string $input): string {
    $chars = [];
    $i = -1;
    while (count($chars) < 8) {
        $md5 = md5($input . ++$i);
        if (str_starts_with($md5, '00000') &&
            is_numeric($md5[5]) &&
            in_array(intval($md5[5]), range(0,7)) &&
            !array_key_exists(intval($md5[5]), $chars)
        ) {
            $chars[$md5[5]] = $md5[6];
        }
    }
    ksort($chars);
    return implode($chars);
}

$input = 'wtnhxymk';

# part 1
assert($expected = '18f47a30' === $actual = firstDoor($in = 'abc'), "$in does not meet expected $expected, got $actual");
$s = microtime(true);
printf("part1: password=%s in (%3f seconds)\n", firstDoor($input), microtime(true) - $s);

# part 2
assert($expected = '05ace8e3' === $actual = secondDoor($in = 'abc'), "$in does not meet expected $expected, got $actual");
$s = microtime(true);
printf("part2: password=%s in (%3f seconds)\n", secondDoor($input), microtime(true) - $s);
