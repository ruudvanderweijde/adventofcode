<?php
function findHash(string $input, int $length): int {
    $s = microtime(true);
    $i = 0;
    while (true) {
        echo "$input - $i in " . round(microtime(true)-$s,2) . "\r";
        if (str_starts_with(md5($input.++$i), str_repeat('0', $length))) {
            echo PHP_EOL;
            return $i;
        }
    }
}

$testCases = [['abcdef', 609043], ['pqrstuv', 1048970]];
foreach($testCases as [$in, $expected]) {
    assert($expected === $actual = findHash($in, 5), "$expected does not match $actual");
}

echo PHP_EOL;
echo findHash('bgvyzdsv', 5);
echo PHP_EOL;
echo findHash('bgvyzdsv', 6);
echo PHP_EOL;
