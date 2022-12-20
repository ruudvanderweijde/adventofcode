<?php
function visit(string $input): int {
    $x = $y = 0;
    $houses["{$x}_{$y}"] = 1;
    foreach (str_split($input) as $d) {
        [$_x, $_y] = match ($d) {
            '^' => [0,-1],
            'v' => [0,1],
            '>' => [1,0],
            '<' => [-1,0],
        };
        $x = $x + $_x;
        $y = $y + $_y;
        $houses["{$x}_{$y}"] = 1;
    }
    return count($houses);
}

$testCases = [['>', 2], ['^>v<', 4], ['^v^v^v^v^v', 2]];
foreach($testCases as [$in, $expected]) {
    assert($expected === $actual = visit($in), "$expected does not match $actual");
}

echo visit(trim(file_get_contents('input')));
echo PHP_EOL;
