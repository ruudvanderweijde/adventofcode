<?php
enum Part { case ONE; case TWO; }

$inputTest = ['Disc #1 has 5 positions; at time=0, it is at position 4.', 'Disc #2 has 2 positions; at time=0, it is at position 1.'];
$input = [
    'Disc #1 has 13 positions; at time=0, it is at position 1.',
    'Disc #2 has 19 positions; at time=0, it is at position 10.',
    'Disc #3 has 3 positions; at time=0, it is at position 2.',
    'Disc #4 has 7 positions; at time=0, it is at position 1.',
    'Disc #5 has 5 positions; at time=0, it is at position 3.',
    'Disc #6 has 17 positions; at time=0, it is at position 5.',
];

function play(array $input, Part $part): int {
    $discs = [];
    foreach ($input as $item) {
        preg_match_all('/[0-9]+/', $item, $matches);
        [, $modulo, , $pos] = array_map('intval', $matches[0]);
        $discs[] = [$pos, $modulo];
    }
    if ($part === Part::TWO) { $discs[] = [0, 11]; }
    for($i=0;$i<INF;$i++) {
        $time = 0;
        $positions = [];
        foreach ($discs as [$pos, $modulo]) {
            $positions[] = ($pos + $i + ++$time) % $modulo;
            if (count(array_unique($positions)) !== 1) { continue 2; }
        }
        break;
    }
    return $i;
}

assert(5 === play(input: $inputTest, part: Part::ONE));
$s = microtime(true);
printf("part1: time=%d in (%3f seconds)\n", play(input: $input, part: Part::ONE), microtime(true) - $s);

$s = microtime(true);
printf("part2: time=%d in (%3f seconds)\n", play(input: $input, part: Part::TWO), microtime(true) - $s);
