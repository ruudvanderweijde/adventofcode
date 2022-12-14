<?php

function compare($left, $right): int {
    if (is_int($left) && is_int($right)) { return $left <=> $right; }
    if (is_int($left)) { $left = [$left]; }
    if (is_int($right)) { $right = [$right]; }

    for($i=0; $i<min(count($left),count($right)); ++$i) {
        if (($compare = compare($left[$i], $right[$i])) !== 0) {
            return $compare;
        }
    }

    return count($left) <=> count($right);
}

$two = '[[2]]';
$six = '[[6]]';
$rows = (
    array_map(
        fn (string $in) => json_decode($in, true),
        explode(PHP_EOL, str_replace(PHP_EOL.PHP_EOL,PHP_EOL, file_get_contents($argv[1] ?? 'input-test') . $two . PHP_EOL . $six))
    )
);
usort($rows, 'compare');
$rows = array_map('json_encode', $rows);

if (($argv[2] ?? '') === 'assert') {
    assert(
        $rows === [
            '[]',
            '[[]]',
            '[[[]]]',
            '[1,1,3,1,1]',
            '[1,1,5,1,1]',
            '[[1],[2,3,4]]',
            '[1,[2,[3,[4,[5,6,0]]]],8,9]',
            '[1,[2,[3,[4,[5,6,7]]]],8,9]',
            '[[1],4]',
            '[[2]]',
            '[3]',
            '[[4,4],4,4]',
            '[[4,4],4,4,4]',
            '[[6]]',
            '[7,7,7]',
            '[7,7,7,7]',
            '[[8,7,6]]',
            '[9]'
        ]
    );
    echo 'Assertion passed!';
    echo PHP_EOL;
}
echo (array_search($two, $rows)+1) * (array_search($six, $rows)+1);
echo PHP_EOL;
