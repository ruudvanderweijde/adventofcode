<?php

$input = file('04.input', FILE_IGNORE_NEW_LINES);

function sectorId(string $in): int
{
    preg_match('/^([a-z-]+)-(\d+)\[([a-z]+)]$/', $in, $matches);
    [, $chars, $id, $checksum] = $matches;
    $values = array_count_values(str_split(str_replace('-', '', $chars)));
    array_multisort($values, SORT_DESC, array_keys($values), SORT_ASC);
    if ($checksum !== implode(array_slice(array_keys($values), 0, 5))) {
        return 0;
    }
    //echo rot($chars, intval($id)) . PHP_EOL;
    if (rot($chars, intval($id)) === 'northpole object storage') {
        echo 'North Pole = ' . $id . PHP_EOL;
    }
    return intval($id);
}

function rot(string $in, int $times): string {
    $out = '';
    foreach (str_split($in) as $char) {
        if ($char === '-') {
            $out .= ' ';
            continue;
        }
        for($i=0;$i<$times%26;++$i) {
            if ($char === 'z') {
                $char = 'a';
            } else {
                $char++;
            }
        }
        $out .= $char;
    }
    return $out;
}

foreach (
    [
        'aaaaa-bbb-z-y-x-123[abxyz]' => 123,
        'a-b-c-d-e-f-g-h-987[abcde]' => 987,
        'not-a-real-room-404[oarel]' => 404,
        'totally-real-room-200[decoy]' => 0,
        'lnkfaypeha-xwogap-skngodkl-888[hwxrv]' => 0,
        'yuxufmdk-sdmpq-eomhqzsqd-tgzf-mocgueufuaz-820[mskbl]' => 0,
    ] as $in => $out) {
    assert($expected = $out === $actual = sectorId(in: $in), "$in does not meet expected $expected, got $actual");
};

# part 1
$s = microtime(true);
printf("part1: sum=%d in (%3f seconds)\n", array_sum(array_map(fn($in) => sectorId($in), $input)), microtime(true) - $s);

# part 2
assert($expected = 'very encrypted name' === $actual = rot(in: $in = 'qzmt-zixmtkozy-ivhz', times: 343), "$in does not meet expected $expected, got $actual");
