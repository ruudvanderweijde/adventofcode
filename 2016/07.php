<?php

function tls(string $in): bool {
    $containsAbba = false;
    foreach(array_map(fn($x) => explode(']', $x), explode('[', $in)) as $group) {
        if (null === ($group[1] ?? null)) {
            if (abba($group[0])) { $containsAbba = true; }
            continue;
        }
        if (abba($group[0])) { return false; }
        if (abba($group[1])) { $containsAbba = true; }
    }
    return $containsAbba;
}

function abba(string $in): bool {
    if (!preg_match_all('/([a-z])([a-z])\2\1/', $in, $matches)) { return false; }
    foreach ($matches[0] as $match) {
        if (!preg_match('/([a-z])\1{3}/', $match)) { return true; }
    }
    return false;
}

function ssl(string $in): bool {
    $toMatch = [];
    $possibleMatches = [];
    foreach(array_map(fn($x) => explode(']', $x), explode('[', $in)) as $group) {
        if (null === ($group[1] ?? null)) {
            $toMatch = array_merge($toMatch, aba($group[0]));
            continue;
        }
        $possibleMatches = array_merge($possibleMatches, aba($group[0]));
        $toMatch = array_merge($toMatch, aba($group[1]));
    }
    foreach ($toMatch as $toM) {
        if (in_array(abaTobab($toM), $possibleMatches)) {
            return true;
        }
    }
    return false;
}

function aba(string $in): array {
    $ret = [];
    if (!preg_match_all('/(?=(([a-z])[a-z]\2))/', $in, $matches)) { return []; }
    foreach ($matches[1] as $match) {
        if (preg_match('/([a-z])\1{2}/', $match)) {
            continue;
        }
        $ret[] = $match;
    }
    return $ret;
}
function abaTobab(string $in): string {
    $split = str_split($in);
    return $split[1] . $split[0] . $split[1];
}
$input = file('07.input', FILE_IGNORE_NEW_LINES);

# part 1
foreach (['abba[mnop]qrst' => true, 'abcd[bddb]xyyx' => false, 'aaaa[qwer]tyui' => false, 'ioxxoj[asdfgh]zxcvbn' => true] as $k => $v) {
    assert($v === tls($k), "Assertion failed for : $k");
}
$s = microtime(true);
printf("part1: count=%d in (%3f seconds)\n", count(array_filter($input, 'tls')), microtime(true) - $s);

# part 2
foreach (['aba[bab]xyz' => true, 'xyx[xyx]xyx' => false, 'aaa[kek]eke' => true, 'zazbz[bzb]cdb' => true] as $k => $v) {
    assert($v === ssl($k), "Assertion failed for : $k");
}
$s = microtime(true);
printf("part2: count=%d in (%3f seconds)\n", count(array_filter($input, 'ssl')), microtime(true) - $s);
