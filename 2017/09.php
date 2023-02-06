<?php
require_once('../lib/assert.php');

function score(string $input): array {
    // remove ! and next char
    $input = preg_replace('/!./', '', $input);

    $depth = 0;
    $score = 0;
    $garbage = false;
    $garbageCount = 0;
    foreach(str_split($input) as $char) {
        if ($char === '>') {
            $garbage = false;
        } elseif($garbage === true) {
            ++$garbageCount;
        } elseif ($char === '<') {
            $garbage = true;
        } elseif ($char === '{') {
            ++$depth;
        } elseif ($char === '}') {
            $score += $depth;
            --$depth;
        }
    }
    return [$score, $garbageCount];
}

assertSame([1,0], score('{}'));
assertSame([6,0], score('{{{}}}'));
assertSame([5,0], score('{{},{}}'));
assertSame([16,0], score('{{{},{},{{}}}}'));
assertSame([1,4], score('{<a>,<a>,<a>,<a>}'));
assertSame([9,8], score('{{<ab>},{<ab>},{<ab>},{<ab>}}'));
assertSame([9,0], score('{{<!!>},{<!!>},{<!!>},{<!!>}}'));
assertSame([3,17], score('{{<a!>},{<a!>},{<a!>},{<ab>}}'));

assertSame([0,0], score('<>'));
assertSame([0,17], score('<random characters>'));
assertSame([0,3], score('<<<<>'));
assertSame([0,2], score('<{!>}>'));
assertSame([0,0], score('<!!>'));
assertSame([0,0], score('<!!!>>'));
assertSame([0,10], score('<{o"i!a,<{i<a>'));

$s = microtime(true);
[$score, $garbage] = score(file('09.input', FILE_IGNORE_NEW_LINES)[0]);
printf("part1: score=%d (in %3f sec)\n", $score, microtime(true)-$s);
printf("part2: garbage=%d (in %3f sec)\n", $garbage, microtime(true)-$s);
