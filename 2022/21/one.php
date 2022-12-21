<?php
$s = microtime(true);
const NIL = -PHP_INT_MAX;
$monkeys = [];
foreach (explode(PHP_EOL, rtrim(file_get_contents($argv[1] ?? 'input-test'))) as $input) {
    if (!preg_match('/(\w{4}): (\d+|(\w+) ([+\-*\/]) (\w+))/', $input, $matches)) {
        throw new Exception('Failed to parse input: ' . $input);
    }
    if (count($matches) === 3) {
        [, $id, $val] = $matches;
        $monkeys[$id] = [$id, intval($val), []];
    } elseif (count($matches) === 6) {
        [, $id, $formula, $lhs, $op, $rhs] = $matches;
        $monkeys[$id] = [$id, NIL, [$lhs, $op, $rhs], $formula];
    } else {
        throw new Exception('Failed to parse input: ' . $input . ' matches: ' . json_encode($matches));
    }
    unset($input, $matches, $id, $val, $lhs, $op, $rhs);
}
unset($argv, $_SERVER);

while ($monkeys['root'][1] <= NIL) {
    foreach ($monkeys as $monkey) {
        [$id, $val, $operation] = $monkey;
        if (count($operation) === 3) {
            [$idL, $op, $idR] = $operation;
            if ((NIL < $l = $monkeys[$idL][1]) && (NIL < $r = $monkeys[$idR][1])) {
                $monkeys[$id][1] = match($op) { '+' => $l+$r, '-' => $l-$r, '*' => $l*$r, '/' => $l/$r };
            }
        }
    }
}

echo sprintf('%d in (%s sec)%s',  $monkeys['root'][1], round(microtime(true)-$s,5), PHP_EOL);
