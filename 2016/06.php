<?php
enum Part { case ONE; case TWO; }
$input = file('06.input', FILE_IGNORE_NEW_LINES);
$testInput = ['eedadn', 'drvtee', 'eandsr', 'raavrd', 'atevrs', 'tsrnev', 'sdttsa', 'rasrtv', 'nssdts', 'ntnada', 'svetve', 'tesnvt', 'vntsnd', 'vrdear', 'dvrsen', 'enarar'];

function code(array $input, Part $part) {
    $chars = [];
    foreach($input as $item) {
        foreach(str_split($item) as $k => $v) {
            $chars[$k][] = $v;
        }
    }

    $code = '';
    foreach ($chars as $items) {
        $values = array_count_values($items);
        asort($values, SORT_NUMERIC);
        $code .= $part === Part::ONE ? array_key_last($values) : array_key_first($values);
    }
    return $code;
}

# part 1
assert($expected = 'easter' === $actual = code($testInput, Part::ONE), "Assertion failed: expected $expected, got $actual");
$s = microtime(true);
printf("part1: code=%s in (%3f seconds)\n", code($input, Part::ONE), microtime(true) - $s);

# part 2
assert($expected = 'advent' === $actual = code($testInput, Part::TWO), "Assertion failed: expected $expected, got $actual");
$s = microtime(true);
printf("part1: code=%s in (%3f seconds)\n", code($input, Part::TWO), microtime(true) - $s);
