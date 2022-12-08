<?php

$field = [];
foreach (file($argv[1] ?? 'input-test') as $line) {
    preg_match('/(\d+),(\d+) -> (\d+),(\d+)/', rtrim($line), $matches);
    [, $lx, $ly, $rx, $ry] = $matches;

    if ($lx === $rx) {
        for ($j = min($ly, $ry); $j <= max($ly, $ry); ++$j) {
            $field[$j][$lx] = ($field[$j][$lx] ?? 0) + 1;
        }
    } else if ($ly === $ry) {
        for ($i = min($lx, $rx); $i <= max($lx, $rx); ++$i) {
            $field[$ly][$i] = ($field[$ly][$i] ?? 0) + 1;
        }
    } else {
        $dirX = $lx < $rx ? 1 : -1;
        $dirY = $ly < $ry ? 1 : -1;
        while ($lx != $rx && $ly != $ry) {
            $field[$ly][$lx] = ($field[$ly][$lx] ?? 0) + 1;
            $lx += $dirX;
            $ly += $dirY;
        }
        $field[$ly][$lx] = ($field[$ly][$lx] ?? 0) + 1;
    }
}

// print for debugging
//for($i=0; $i<=9; ++$i) {
//    for($j=0; $j<=9; ++$j) {
//        echo ($field[$i][$j] ?? ".") . " ";
//    }
//    echo PHP_EOL;
//}

echo array_sum(
    array_map(
        fn($i) => array_sum(
            array_map(
                fn($j) => $j > 1 ? 1 : 0,
                $i
            )
        ),
        $field
    )
);
echo PHP_EOL;
