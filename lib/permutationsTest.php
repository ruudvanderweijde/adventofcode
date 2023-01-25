<?php
require_once(__DIR__ . '/permutations.php');

function test(array $input, array $expected)
{
    assert(
        ($actual = iterator_to_array(permutations($input))) === $expected,
        'Input [' . json_encode($input) . '] not meet expected [' . json_encode($expected) . '], got [' . json_encode($actual) . '] instead'
    );
}

test(input: ['a'], expected: [['a']]);
test(input: ['a', 'b'], expected: [['a', 'b'], ['b', 'a']]);
test(
    input: ['a', 'b', 'c'],
    expected: [
        ['a', 'b', 'c'],
        ['b', 'a', 'c'],
        ['b', 'c', 'a'],
        ['a', 'c', 'b'],
        ['c', 'a', 'b'],
        ['c', 'b', 'a'],
    ]
);