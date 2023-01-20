<?php
enum Part { case ONE; case TWO; }
function getIndex(string $salt, Part $part): int
{
    $keys = [];
    $toCheck = [];
    $i = -1;

    while (++$i >= 0) {
        $md5 = md5($salt . $i);
        if ($part === Part::TWO) {
            for($j=0;$j<2016;$j++) $md5 = md5($md5);
        }
        foreach ($toCheck as $_i => $regex) {
            if ($i - 1000 > $_i) {
                unset($toCheck[$_i]);
                continue;
            }
            if (preg_match($regex, $md5)) {
                $keys[] = $_i;
                echo "$i :: Keys: " . count($keys) . "\r";
                if (count($keys) === 64) { return $_i; }
                unset($toCheck[$_i]);
            }
        }
        if (preg_match('/([0-9a-z])\1{2}/', $md5, $matches)) {
            $toCheck[$i] = "/$matches[1]{5}/";
        }
    }
    return -1;
}

assert(22728 === getIndex(salt: 'abc', part: Part::ONE));
$s = microtime(true);
printf("part1: item=%d in (%3f seconds)\n", getIndex(salt: 'zpqevtbw', part: Part::ONE), microtime(true) - $s);

assert(22551 === getIndex(salt: 'abc', part: Part::TWO));
$s = microtime(true);
printf("part2: item=%d in (%3f seconds)\n", getIndex(salt: 'zpqevtbw', part: Part::TWO), microtime(true) - $s);
