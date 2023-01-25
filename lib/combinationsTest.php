<?php
require_once(__DIR__ . '/combinations.php');

function test(iterable $input, int $size, iterable $expected)
{
    assert(
        ($actual = iterator_to_array(combinations($input, $size))) === $expected,
        'Input [' . json_encode($input) . '] not meet expected [' . json_encode($expected) . '], got [' . json_encode($actual) . '] instead'
    );
}

test(input: [0, 1, 2], size: 1, expected: [[0], [1], [2]]);
test(input: ['a', 'b', 'c'], size: 2, expected: [['a', 'b'], ['a', 'c'], ['b', 'c']]);
test(input: [0, 1, 2, 3, 4], size: 3, expected: [[0, 1, 2], [0, 1, 3], [0, 1, 4], [0, 2, 3], [0, 2, 4], [0, 3, 4], [1, 2, 3], [1, 2, 4], [1, 3, 4], [2, 3, 4]]);