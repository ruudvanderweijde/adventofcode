<?php
$filename = $argv[1] ?? 'input-test';

$map = [];
foreach(array_map(fn (string $in) => explode(' -> ' , trim($in)), file($filename)) as [$rhs, $assign]) {
    $map[$assign] = is_numeric($rhs) ? intval($rhs) : $rhs;
}
unset($argv, $assign, $filename, $rhs, $_SERVER);

while (true) {
    $stop = true;
    foreach ($map as $k => $v) {
        if (is_int($v)) {
            continue;
        }
        $stop = false;
        $matches = explode(' ', $v);
        if (1 === count($matches)) {
            if (is_numeric($map[$matches[0]])) {
                $map[$k] = $map[$matches[0]];
            }
        } elseif (2 === count($matches)) {
            // NOT x -> y
            [, $rhs] = $matches;
            $rhs = is_numeric($rhs) ? intval($rhs) : $map[$rhs];
            if (is_int($rhs)) {
                $map[$k] = 65535 ^ $rhs;
            }
        } elseif (3 === count($matches)) {
            [$lhs, $op, $rhs] = $matches;
            $lhs = is_numeric($lhs) ? intval($lhs) : $map[$lhs];
            $rhs = is_numeric($rhs) ? intval($rhs) : $map[$rhs];
            if (is_int($lhs) && is_int($rhs)) {
                $map[$k] = match($op) {
                    'AND'    => $lhs & $rhs,
                    'OR'     => $lhs | $rhs,
                    'LSHIFT' => $lhs << $rhs,
                    'RSHIFT' => $lhs >> $rhs,
                };
            }
        }
    }
    if ($stop) {
        break;
    }
}
echo $map['a'];
echo PHP_EOL;
