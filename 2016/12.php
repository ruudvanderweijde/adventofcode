<?php

$inputTest = ['cpy 41 a', 'inc a', 'inc a', 'dec a', 'jnz a 2', 'dec a'];
$input = ['cpy 1 a', 'cpy 1 b', 'cpy 26 d', 'jnz c 2', 'jnz 1 5', 'cpy 7 c', 'inc d', 'dec c', 'jnz c -2', 'cpy a c', 'inc a', 'dec b', 'jnz b -2', 'cpy c b', 'dec d', 'jnz d -6', 'cpy 14 c', 'cpy 14 d', 'inc a', 'dec d', 'jnz d -2', 'dec c', 'jnz c -5'];

$registers = ['a'=>0,'b'=>0,'c'=>0,'d'=>0,'e'=>0];

function process(array $registers, array $instructions): int {
    $size = count($instructions);
    for($i=0; $i<$size; $i++) {
        $cmd = explode(' ', $instructions[$i]);
        if ($cmd[0] === 'cpy') { $registers[$cmd[2]] = is_numeric($cmd[1]) ? intval($cmd[1]) : $registers[$cmd[1]]; }
        elseif ($cmd[0] === 'inc') { ++$registers[$cmd[1]]; }
        elseif ($cmd[0] === 'dec') { --$registers[$cmd[1]]; }
        elseif ($cmd[0] === 'jnz' && (is_numeric($cmd[1]) ? intval($cmd[1]) : $registers[$cmd[1]]) !== 0) { --$i; $i += (intval($cmd[2]) % $size); }
    }
    return $registers['a'];
}

assert(42 === process($registers, $inputTest));
$s = microtime(true);
printf("part1: a=%d in (%3f seconds)\n", process($registers, $input), microtime(true) - $s);

$registers['c'] = 1;
$s = microtime(true);
printf("part2: a=%d in (%3f seconds)\n", process($registers, $input), microtime(true) - $s);
