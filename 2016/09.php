<?php
enum Part { case ONE; case TWO; }

$input = file('09.input', FILE_IGNORE_NEW_LINES);

function decompress(string $in): int {
    global $part;
    $ret = 0;
    while (false !== ($l = strpos($in, '(')) && false !== ($r = strpos($in, ')'))) {
        $ret += $l;
        $marker = array_map('intval', explode('x', substr($in, $l+1, $r-$l-1)));
        $in = substr($in, $r+1);
        if ($part === Part::ONE) {
            $ret += strlen(str_repeat(substr($in, 0, $marker[0]), $marker[1]));
        } else if ($part === Part::TWO) {
            $ret += decompress(str_repeat(substr($in, 0, $marker[0]), $marker[1]));
        }
        $in = substr($in, $marker[0]);
    }

    return $ret + strlen($in);
}

# part 1
$part = Part::ONE;
foreach (
    [
        'ADVENT' => 'ADVENT',
        'A(1x5)BC' => 'ABBBBBC',
        '(3x3)XYZ' => 'XYZXYZXYZ',
        'A(2x2)BCD(2x2)EFG' => 'ABCBCDEFEFG',
        '(6x1)(1x3)A' => '(1x3)A',
        'X(8x2)(3x3)ABCY' => 'X(3x3)ABC(3x3)ABCY',
    ] as $in => $out) {
    assert(($expected = strlen($out)) === $actual = decompress(in: $in), "$in does not meet expected $expected, got $actual");
};

$s = microtime(true);
printf("part1: count=%d in (%3f seconds)\n", array_sum(array_map('decompress', $input)), microtime(true) - $s);

# part 2
$part = Part::TWO;
foreach (
    [
        '(3x3)XYZ' => 'XYZXYZXYZ',
        'X(8x2)(3x3)ABCY' => 'XABCABCABCABCABCABCY',
        '(27x12)(20x12)(13x14)(7x10)(1x12)A' => str_repeat('A', 241920),
    ] as $in => $out) {
    assert(($expected = strlen($out)) === $actual = decompress(in: $in), "$in does not meet expected $expected, got $actual");
};
$s = microtime(true);
printf("part1: count=%d in (%3f seconds)\n", array_sum(array_map('decompress', $input)), microtime(true) - $s);
