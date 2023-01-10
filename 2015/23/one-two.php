<?php
$s = microtime(true);

$registers = ['a' => intval(($argv[2] ?? 0)), 'b' => 0];
$instructions = file($argv[1] ?? 'input', FILE_IGNORE_NEW_LINES);
for ($i=0; $i<=count($instructions)-1; $i++) {
    echo "i=$i, $instructions[$i], " . json_encode($registers) . "\n";
    [$part1, $part2] = explode(' ', str_replace(',', '', $instructions[$i]), 2);
    if ($part1 === 'hlf') {
        $registers[$part2] /= 2;
    } else if ($part1 === 'tpl') {
        $registers[$part2] *= 3;
    } else if ($part1 === 'inc') {
        $registers[$part2] += 1;
    } else if ($part1 === 'jmp') {
        $i += intval($part2)-1;
    } else if ($part1 === 'jie') {
        [$part2, $part3] = explode(' ', $part2);
        if ($registers[$part2] % 2 === 0) {
            $i += intval($part3)-1;
        }
    } else if ($part1 === 'jio') {
        [$part2, $part3] = explode(' ', $part2);
        if ($registers[$part2] === 1) {
            $i += intval($part3)-1;
        }
    }
}

printf("a=%d, b=%d (in %3f sec)\n", $registers['a'], $registers['b'], microtime(true)-$s);