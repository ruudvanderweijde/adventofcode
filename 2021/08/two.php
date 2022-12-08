<?php

const SIZES = [
    1 => 2,
    7 => 3,
    4 => 4,
    532 => 5,
    960 => 6,
    8 => 7,
];

function sortString(string $input): string {
    $split = str_split($input);
    sort($split);
    return implode('', $split);
}

function decode(array $input): array {
    $input = array_map('sortString', $input);

    foreach (SIZES as $num => $count) {
        $known[$num] = array_filter($input, fn ($i) => strlen($i) === $count);
    }

    $top = join(array_diff(str_split(current($known[7])),str_split(current($known[1]))));

    $uniqueCount = array_count_values(str_split(join($input)));
    $leftBottom = array_search(4, $uniqueCount);
    $leftTop = array_search(6, $uniqueCount);
    $rightBottom = array_search(9, $uniqueCount);
    $rightTop = str_replace($top, '', join(array_keys($uniqueCount, 8)));
    $middle = array_search(2, array_count_values(str_split(str_replace([$leftTop, $leftBottom, $rightTop, $rightBottom], '', join($known[960])))));
    $bottom = str_replace([$top, $middle, $leftTop, $leftBottom, $rightTop, $rightBottom], '', join($known[8]));

    $known[0] = sortString($top.$leftTop.$leftBottom.$bottom.$rightBottom.$rightTop);
    $known[1] = current($known[1]);
    $known[2] = sortString($top.$rightTop.$middle.$leftBottom.$bottom);
    $known[3] = sortString($top.$rightTop.$middle.$rightBottom.$bottom);
    $known[4] = current($known[4]);
    $known[5] = sortString($top.$leftTop.$middle.$rightBottom.$bottom);
    $known[6] = sortString($top.$leftTop.$middle.$leftBottom.$rightBottom.$bottom);
    $known[7] = current($known[7]);
    $known[8] = current($known[8]);
    $known[9] = sortString($top.$leftTop.$rightTop.$middle.$bottom.$rightBottom);

    unset($known[532]);
    unset($known[960]);

    return $known;
}
$values = [];
foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $line) {
    [$inputEncoded, $outputEncoded] = explode(' | ', $line);
    $decoded = decode(explode(' ', $inputEncoded), []);
    $values[] = intval(join(array_map(
        fn ($x) => array_search(sortString($x), $decoded),
        explode(' ', $outputEncoded)
    )));
}
echo array_sum($values);
echo PHP_EOL;
