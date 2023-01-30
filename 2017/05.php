<?php
require_once('../lib/partEnum.php');

function read(string $file): array {
    return array_map('intval', file($file, FILE_IGNORE_NEW_LINES));
}

function process(array $in): int {
    global $part;
    $steps = 0;
    $pointer = 0;
    while (++$steps) {
        $prev = $pointer;
        $pointer += $offset = $in[$pointer];
        if ($part === Part::TWO && $offset >= 3) {
            --$in[$prev];
        } else {
            ++$in[$prev];
        }
        if (!array_key_exists($pointer, $in)) {
            break;
        }
    }
    return $steps;
}

$part = Part::ONE;
assert(5 === process(read('05.test')));
$s = microtime(true);
printf("part1: count=%d (in %3f sec)\n", process(read('05.input')), microtime(true)-$s);

$part = Part::TWO;
assert(10 === process(read('05.test')));
$s = microtime(true);
printf("part2: count=%d (in %3f sec)\n", process(read('05.input')), microtime(true)-$s);
