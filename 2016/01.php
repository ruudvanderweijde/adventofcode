<?php
const DIRECTIONS = [[-1,0],[0,1],[1,0],[0,-1]];

$input = <<<INPUT
L4, L1, R4, R1, R1, L3, R5, L5, L2, L3, R2, R1, L4, R5, R4, L2, R1, R3, L5, R1, L3, L2, R5, L4, L5, R1, R2, L1, R5, L3, R2, R2, L1, R5, R2, L1, L1, R2, L1, R1, L2, L2, R4, R3, R2, L3, L188, L3, R2, R54, R1, R1, L2, L4, L3, L2, R3, L1, L1, R3, R5, L1, R5, L1, L1, R2, R4, R4, L5, L4, L1, R2, R4, R5, L2, L3, R5, L5, R1, R5, L2, R4, L2, L1, R4, R3, R4, L4, R3, L4, R78, R2, L3, R188, R2, R3, L2, R2, R3, R1, R5, R1, L1, L1, R4, R2, R1, R5, L1, R4, L4, R2, R5, L2, L5, R4, L3, L2, R1, R1, L5, L4, R1, L5, L1, L5, L1, L4, L3, L5, R4, R5, R2, L5, R5, R5, R4, R2, L1, L2, R3, R5, R5, R5, L2, L1, R4, R3, R1, L4, L2, L3, R2, L3, L5, L2, L2, L1, L2, R5, L2, L2, L3, L1, R1, L4, R2, L4, R3, R5, R3, R4, R1, R5, L3, L5, L5, L3, L2, L1, R3, L4, R3, R2, L1, R3, R1, L2, R4, L3, L3, L3, L1, L2
INPUT;

function distance(string $instructions, bool $part2 = false): int {
    $visited = [];
    $y = $x = 0;
    $d = 0;
    foreach (explode(', ', $instructions) as $instruction) {
        preg_match('/^([LR])(\d+)$/', $instruction, $matches);
        $d = match($matches[1]) {
            'L' => $d === 0 ? 3 : $d-1,
            'R' => $d === 3 ? 0 : $d+1,
        };

        for ($i=0; $i<intval($matches[2]); ++$i) {
            $y += DIRECTIONS[$d][0];
            $x += DIRECTIONS[$d][1];
            if ($part2) {
                if (array_key_exists($key = "{$y}_{$x}", $visited)) { break 2; }
                $visited[$key] = 1;
            }
        }

    }

    return abs($y - $x);
}

# part 1
assert(5 === $distance = distance(instructions: 'R2, L3'), "$distance does not meet expected 5");
assert(2 === $distance = distance(instructions: 'R2, R2, R2'), "$distance does not meet expected 2");
assert(12 === $distance = distance(instructions: 'R5, L5, R5, R3'), "$distance does not meet expected 12");

$s = microtime(true);
printf("part1: distance=%d in (%3f seconds)\n", distance(instructions: $input), microtime(true)-$s);

# part 2
assert(4 === $distance = distance(instructions: 'R8, R4, R4, R8', part2: true), "$distance does not meet expected 12");

$s = microtime(true);
printf("part2: distance=%d in (%3f seconds)\n", distance(instructions: $input, part2: true), microtime(true)-$s);