<?php
function visit(string $input): int {
    $santaX = $santaY = 0;
    $robotX = $robotY = 0;
    $houses["{$robotX}_{$robotY}"] = 1;
    foreach (array_chunk(str_split($input), 2) as [$santaD, $robotD]) {
        [$_santaX, $_santaY] = match ($santaD) { '^' => [0,-1], 'v' => [0,1], '>' => [1,0], '<' => [-1,0] };
        $santaX = $santaX + $_santaX;
        $santaY = $santaY + $_santaY;
        $houses["{$santaX}_{$santaY}"] = 1;
        [$_robotX, $_robotY] = match ($robotD) { '^' => [0,-1], 'v' => [0,1], '>' => [1,0], '<' => [-1,0] };
        $robotX = $robotX + $_robotX;
        $robotY = $robotY + $_robotY;
        $houses["{$robotX}_{$robotY}"] = 1;
    }
    return count($houses);
}

$testCases = [['^v', 3], ['^>v<', 3], ['^v^v^v^v^v', 11]];
foreach($testCases as [$in, $expected]) {
    assert($expected === $actual = visit($in), "$expected does not match $actual");
}

echo visit(trim(file_get_contents('input')));
echo PHP_EOL;
