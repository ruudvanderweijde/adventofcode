<?php

require_once(__DIR__ . '/../lib/permutations.php');

$instructions = file('21.input', FILE_IGNORE_NEW_LINES);
$input = 'abcdefgh';

function swapPosition(string $input, int $l, int $r): string
{
    $_l = $input[$l];
    $_r = $input[$r];

    $input[$l] = $_r;
    $input[$r] = $_l;

    return $input;
}
assert('ebcda' === swapPosition('abcde', 4, 0));

function swapLetter(string $input, string $l, string $r): string {
    $_l = strpos($input, $l);
    $_r = strpos($input, $r);

    $input[$_l] = $r;
    $input[$_r] = $l;

    return $input;
}
assert('edcba' === swapLetter('ebcda', 'd', 'b'));

function rotateLeft(string $input, int $count) {
    $chars = str_split($input);
    for($i=0;$i<$count;++$i) {
        $first = array_shift($chars);
        $chars[] = $first;
    }
    return join($chars);
}
assert('bcdea' === rotateLeft('abcde', 1));

function rotateRight(string $input, int $count) {
    $chars = str_split($input);
    for($i=0;$i<$count;++$i) {
        $last = array_pop($chars);
        array_unshift($chars, $last);
    }
    return join($chars);
}
assert('dabc' === rotateRight('abcd', 1));
assert('deabc' === rotateRight('abcde', 2));

function reverse(string $input, int $start, int $end) {
    $chars = str_split($input);
    $lhs = array_slice($chars, 0, $start);
    $mid = array_slice($chars, $start, $end-$start+1);
    $rhs = strlen($input)-1 === $end ? [] : array_slice($chars, $end+1-strlen($input));
    return join(array_merge($lhs, array_reverse($mid), $rhs));
}
assert('abcde' === reverse('edcba', 0, 4));
assert('ebcda' === reverse('edcba', 1, 3));

function move(string $input, int $x, int $y) {
    $chars = str_split($input);
    $toMove = $chars[$x];
    unset($chars[$x]);
    $chars = array_values($chars);
    $lhs = array_slice($chars, 0, $y);
    $rhs = array_slice($chars, $y);
    return join(array_merge($lhs, [$toMove], $rhs));

}
assert('bdeac' === move('bcdea', 1, 4));
assert('abdec' === move('bdeac', 3, 0));

function scramble(array $instructions, string $input): string {
    foreach ($instructions as $instruction) {
        if (preg_match('/^swap position (\d) with position (\d)$/', $instruction, $m)) {
            $input = swapPosition($input, intval($m[1]), intval($m[2]));
        } elseif (preg_match('/^swap letter (\w) with letter (\w)$/', $instruction, $m)) {
            $input = swapLetter($input, $m[1], $m[2]);
        } elseif (preg_match('/^rotate left (\d+) steps?$/', $instruction, $m)) {
            $input = rotateLeft($input, $m[1]);
        } elseif (preg_match('/^rotate right (\d+) steps?$/', $instruction, $m)) {
            $input = rotateRight($input, $m[1]);
        } elseif (preg_match('/^rotate based on position of letter (\w)$/', $instruction, $m)) {
            $index = strpos($input, $m[1]);
            $input = rotateRight($input, $index >= 4 ? $index + 2 : $index + 1);
        } elseif (preg_match('/^reverse positions (\d) through (\d)$/', $instruction, $m)) {
            $input = reverse($input, intval($m[1]), intval($m[2]));
        } elseif (preg_match('/^move position (\d) to position (\d)$/', $instruction, $m)) {
            $input = move($input, intval($m[1]), intval($m[2]));
        }
    }
    return $input;
}

$testInstructions = [
    'swap position 4 with position 0',      // ebcda
    'swap letter d with letter b',          // edcba
    'reverse positions 0 through 4',        // abcde
    'rotate left 1 step',                   // bcdea
    'move position 1 to position 4',        // bdeac
    'move position 3 to position 0',        // abdec
    'rotate based on position of letter b', // ecabd
    'rotate based on position of letter d', // decab
];
$testInput = 'abcde';
assert('decab' === scramble($testInstructions, $testInput));

$s = microtime(true);
printf("part1: password=%s in (%3f seconds)\n", scramble($instructions, $input), microtime(true) - $s);

$s = microtime(true);
$input2 = 'fbgdceah';
foreach (permutations(str_split($input2)) as $permutation) {
    if ($input2 === scramble($instructions, join($permutation))) {
        printf("part2: password=%s in (%3f seconds)\n", join($permutation), microtime(true) - $s);
    }
}
