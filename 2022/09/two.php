<?php

$filename = $argv[1] ?? 'input-test';

$rope = array_fill(0, 10, ['x' => 0, 'y' => 0]);

function printGrid(array $rope, int $size = 26) {
    $field = array_map(fn ($x) => array_fill(0, $size, '.'), range(0,$size-1));
    foreach($field as $row => $columns) {
        foreach($columns as $column => $val) {
            $val = array_key_first(array_filter($rope, fn($in) => $in['x'] == $column && $in['y'] == $row)) ?? $val;
            echo $val == 0 ? 'H' : $val;
         }
        echo PHP_EOL;
    }
}
foreach (array_map('rtrim', file($filename)) as $instruction) {
    [$direction, $count] = explode(' ', $instruction);
    $x = match($direction) { 'L' => -1, 'R' => 1, 'U', 'D' => 0 };
    $y = match($direction) { 'L', 'R' => 0, 'U' => 1, 'D' => -1 };

    //echo "\n\n==> $instruction\n\n";
    for($i=0; $i<$count; ++$i) {
        $rope[0]['x'] += $x;
        $rope[0]['y'] += $y;

        for ($k=1; $k<10; ++$k) {
            $xDiff = abs($rope[$k - 1]['x'] - $rope[$k]['x']);
            $yDiff = abs($rope[$k - 1]['y'] - $rope[$k]['y']);
            $totalDiff = $xDiff + $yDiff;
            if ($totalDiff === 1) continue;
            if ($yDiff === 2) {
                if ($totalDiff === 3) $rope[$k]['x'] = $rope[$k-1]['x'];
                $rope[$k]['y'] += $rope[$k-1]['y'] < $rope[$k]['y'] ? -1 : 1;
            }
            if ($xDiff === 2) {
                $rope[$k]['x'] += $rope[$k-1]['x'] < $rope[$k]['x'] ? -1 : 1;
                if ($totalDiff === 3) $rope[$k]['y'] = $rope[$k-1]['y'];
            }
        }
        //printGrid($rope, 6);
        $trail["{$rope[9]['x']}_{$rope[9]['y']}"] = 1;
        //echo json_encode($rope) . PHP_EOL;
        //echo " > H [$headX,$headY] \t T [$tailX,$tailY]\n";
    }
}

echo count($trail);
echo PHP_EOL;
