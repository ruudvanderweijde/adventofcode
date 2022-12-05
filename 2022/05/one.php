<?php

function load(string $filename): array
{
    $data = file($filename);
    $split = array_search(PHP_EOL, $data);

    return [
        parseStack(array_reverse(array_slice($data, 0, $split - 1))),
        array_slice($data, $split + 1),
    ];
}

/**
 * in:
 *      [D]
 *  [N] [C]
 *  [Z] [M] [P]
 *   1   2   3
 *
 * out:
 *  1: ['Z', 'N']
 *  2: ['M', 'C', 'D']
 *  3: ['P']
 */
function parseStack(array $input): array
{
    $stack = [];
    foreach ($input as $item) {
        foreach (str_split($item, 4) as $index => $value) {
            if ($val = preg_replace('/[^A-Z]/', '', $value)) {
                $stack[$index+1] = $stack[$index+1] ?? [];
                array_push($stack[$index+1], $val);
            }
        }
    }
    return $stack;
}

function handle(string $filename): string
{
    [$stack, $instructions] = load($filename);
    foreach ($instructions as $instruction) {
        preg_match('/^move (\d+) from (\d+) to (\d+)\s$/', $instruction, $matches);
        [, $count, $from, $to] = $matches;
        do {
            array_push($stack[$to], array_pop($stack[$from]));
        } while (--$count > 0);
    }

    return join('', array_map(fn(array $in) => array_pop($in), $stack));
}

$testScore = handle('input-test');
assert('CMZ' === $testScore, sprintf('Expected CMZ, got [%d] instead.', $testScore));
var_dump('Test passed!');

var_dump(handle('input'));
