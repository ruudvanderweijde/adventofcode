<?php

$inputPart1 = array_map(fn (string $in) => explode(' ', $in), file('03.input', FILE_IGNORE_NEW_LINES));

function triagles(array $input): int {
    $count = 0;
    foreach ($input as $numbers) {
        sort($numbers, SORT_NUMERIC);
        $count += $numbers[0] + $numbers[1] > $numbers[2];
    }
    return $count;
}

# part 1
$s = microtime(true);
printf("part1: count=%d in (%3f seconds)\n", triagles(input: $inputPart1), microtime(true)-$s);

# part 2
$s = microtime(true);
$inputPart2 = [];
for($i=0;$i<count($inputPart1); $i+=3) {
    $inputPart2[] = [$inputPart1[$i][0], $inputPart1[$i+1][0], $inputPart1[$i+2][0]];
    $inputPart2[] = [$inputPart1[$i][1], $inputPart1[$i+1][1], $inputPart1[$i+2][1]];
    $inputPart2[] = [$inputPart1[$i][2], $inputPart1[$i+1][2], $inputPart1[$i+2][2]];
}
printf("part2: count=%d in (%3f seconds)\n", triagles(input: $inputPart2), microtime(true)-$s);
