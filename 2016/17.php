<?php
enum Part { case ONE; case TWO; }
const DIRECTIONS = [
    ['U',[-1, 0]],
    ['D',[ 1, 0]],
    ['L',[ 0,-1]],
    ['R',[ 0, 1]],
];

function solve(string $passcode, Part $part): string
{
    $queue = [[0, [0, 0], '']];
    $path = str_repeat('UNKNOWN', $part === Part::ONE ? 1000 : 0);
    while (count($queue) > 0) {
        [$steps, [$y, $x], $visited] = array_shift($queue);

        if ($steps > strlen($path) && $part === Part::ONE) { continue; }
        if ($y === 3 && $x === 3) {
            if ($part === Part::ONE) {
                $path = strlen($visited) < strlen($path) ? $visited : $path;
            } else {
                $path = strlen($visited) > strlen($path) ? $visited : $path;
            }
            continue;
        }

        $doors = array_filter(str_split(substr(md5($passcode . $visited), 0, 4)), fn(string $c) => in_array($c, ['b', 'c', 'd', 'e', 'f']));
        foreach ($doors as $index => $_) {
            $_y = $y + DIRECTIONS[$index][1][0];
            $_x = $x + DIRECTIONS[$index][1][1];
            if (min($_y, $_x) < 0 || max($_y, $_x) > 3) {
                continue;
            }
            $queue[] = [$steps + 1, [$_y, $_x], $visited . DIRECTIONS[$index][0]];
        }
    }
    return $path;
}

assert('DDRRRD' === solve('ihgpwlah', Part::ONE));
assert('DDUDRLRRUDRD' === solve('kglvqrro', Part::ONE));
assert('DRURDRUDDLLDLUURRDULRLDUUDDDRR' === solve('ulqzkmiv', Part::ONE));

$s = microtime(true);
printf("part1: path=%s in (%3f seconds)\n", solve('gdjjyniy', Part::ONE), microtime(true) - $s);

assert(370 === strlen(solve('ihgpwlah', Part::TWO)));
assert(492 === strlen(solve('kglvqrro', Part::TWO)));
assert(830 === strlen(solve('ulqzkmiv', Part::TWO)));

$s = microtime(true);
printf("part2: max=%d in (%3f seconds)\n", strlen(solve('gdjjyniy', Part::TWO)), microtime(true) - $s);
