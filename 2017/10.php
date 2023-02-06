<?php
require_once('../lib/assert.php');

$input = [97,167,54,178,2,11,209,174,119,248,254,0,255,1,64,190];

function reverse(int $size, array $lengths, int $repeat = 1): array {
    $pos = 0;
    $skip = 0;
    $numbers = range(0,$size-1);

    for ($i = 0; $i < $repeat; $i++) {
        foreach ($lengths as $length) {
            if ($length > 1) {
                $itemsToRotate = array_merge(
                    array_slice(array: $numbers, offset: $pos, length: $length),
                    $pos + $length > ($size - 1)
                        ? array_slice(array: $numbers, offset: 0, length: ($pos + $length) % $size)
                        : []
                );
                $newNumbers = $numbers;
                $tmpPos = $pos;
                foreach (array_reverse($itemsToRotate) as $item) {
                    $newNumbers[$tmpPos % $size] = $item;
                    ++$tmpPos;
                }
                $numbers = $newNumbers;
            }
            $pos += $length + $skip;
            $pos %= $size;
            ++$skip;
        }
    }
    return $numbers;
}

assertSame([3,4,2,1,0], reverse(5, [3,4,1,5]));

$s = microtime(true);
$numbers = reverse(256, $input);
printf("part1: score=%d (in %3f sec)\n", $numbers[0] * $numbers[1], microtime(true)-$s);

function dense(array $input)
{
    return array_map(
        fn (array $part) => array_reduce(
            $part,
            fn ($carry, $item) => $carry ^= $item
        ),
        array_chunk($input, 16)
    );
}
assertSame([64], dense([65, 27, 9, 1, 4, 3, 40, 50, 91, 7, 6, 0, 2, 5, 68, 22]));

function knothash(array $input): string {
    return join(
        array_map(
            fn (string $hex) => strlen($hex) == 2 ? $hex : '0' . $hex,
            array_map('dechex', $input)
        )
    );
}

$s = microtime(true);
$input = array_merge(array_map('ord', str_split(join(',', $input))), [17, 31, 73, 47, 23]);
$numbers = reverse(256, $input, 64);
printf("part2: hash=%s (in %3f sec)\n", knothash(dense($numbers)), microtime(true)-$s);