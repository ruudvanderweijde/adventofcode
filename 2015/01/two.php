<?php
function getBasement(string $input): int {
    $target = -1;
    $floor = 0;
    foreach (str_split($input) as $pos => $char) {
        $floor += match($char) { '(' => 1, ')' => -1 };
        if ($floor === $target) {
            return $pos + 1;
        }
    }
    return -1;
}

foreach([[')', 1], ['()())', 5]] as [$in, $expected]) {
    assert($expected === $actual = getRibbon($in), "$expected does not match $actual");
}

echo getRibbon(trim(file_get_contents('input')));
echo PHP_EOL;
