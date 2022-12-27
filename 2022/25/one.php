<?php

const ASSERTIONS = [
    '1' => 1, '2' => 2, '1=' => 3, '1-' => 4, '10' => 5, '11' => 6, '12' => 7, '2=' => 8, '2-' => 9, '20' => 10, '1=0' => 15, '1-0' => 20, '1=11-2' => 2022, '1-0---0' => 12345, '1121-1110-1=0' => 314159265,
    '1=-0-2' => 1747, '12111' => 906, '2=0=' => 198, '21' => 11, '2=01' => 201, '111' => 31, '20012' => 1257, '112' => 32, '1=-1=' => 353, '1-12' => 107, '122' => 37
];
const SNAFU = [
    -2 => '=',
    -1 => '-',
    0  => '0',
    1  => '1',
    2  => '2'
];

function SNAFUtoDECIMAL(string $in): int {
    $out = 0;
    foreach (str_split(strrev($in)) as $index => $value) {
        $out += pow(5, $index) * array_search($value, SNAFU);
    }
    return $out;
}
function DECIMALtoSNAFU(int $in): string {
    $out = '';
    while ($in > 0) {
        $out .= ($in + 2) % 5;
        $in = floor(($in+2) / 5);
    }
    return strrev(str_replace(range(0,4),SNAFU, $out));
}

DECIMALtoSNAFU(12345);
foreach (ASSERTIONS as $snafu => $decimal) {
    assert($decimal === $actual = SNAFUtoDECIMAL($snafu), "SNAFUtoDECIMAL: [$snafu] does not equal [$decimal], got [$actual] instead");
    assert((string) $snafu === $actual = DECIMALtoSNAFU($decimal), "DECIMALtoSNAFU: [$decimal] does not equal [$snafu], got [$actual] instead");
}

echo DECIMALtoSNAFU(
    array_sum(
        array_map('SNAFUtoDECIMAL', array_map('rtrim', explode(PHP_EOL, rtrim(file_get_contents('input')))))
    )
);
echo PHP_EOL;
