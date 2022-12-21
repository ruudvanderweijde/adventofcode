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

$monkeys['root'][3] = str_replace('+', '=', $monkeys['root'][3]);
$monkeys['humn'][1] = 'x';
$formula = $monkeys['root'][3];
while (preg_match_all('/(\w{4})/', $formula, $matches)) {
    foreach($matches[0] as $match) {
        $replacement = $monkeys[$match][1] != NIL ? $monkeys[$match][1] : $monkeys[$match][3];
        $formula = str_replace($match, '('.$replacement.')', $formula);
    }
}
unset($monkeys, $matches, $match, $replacement);
echo 'Full formula: ' . PHP_EOL . $formula . PHP_EOL . PHP_EOL;

// simplify formula
while (true) {
    $prev = $formula;
    $formula = preg_replace('/\((\d+)\)/', '$1', $formula);

    while (preg_match('/(\(\s*(\d+)\s+([+\-*\/])\s+(\d+)\s*\))/U', $formula, $matches)) {
        [$all, , $l, $op, $r] = $matches;
        $val = match($op) { '+' => $l+$r, '-' => $l-$r, '*' => $l*$r, '/' => $l/$r };
        $formula = str_replace($all, $val, $formula);
    }
    if ($prev === $formula) { break; }
    $prev = $formula;
}
unset($prev, $all, $l, $op, $r, $val);
echo 'Shorter formula: ' . PHP_EOL . $formula . PHP_EOL . PHP_EOL;

[$l, $r] = explode(' = ', $formula);
$res = intval(preg_match('/^\d+$/', $l) ? $l : $r);
$x = preg_match('/^\d+$/', $l) ? $r : $l;
unset($l, $r, $formula);

echo 'Solving equation:' . PHP_EOL;
while (preg_match('/^\((\d+)\s+([+\-*\/])\s+(.*)\)$/', $x, $matches) || preg_match('/^\((.*)\s+([+\-*\/])\s+(\d+)\)$/', $x, $matches2)) {
    echo "$x = $res\n";
    $matches = count($matches) > 0 ? $matches :  $matches2;
    [, $l, $op, $r] = $matches;
    if (preg_match('/^\d+$/', $l)) {
        // left side is the number...
        $l = intval($l);
        $res = match ($op) {
            '+' => $res - $l,
            '-' => ($res - $l) * -1,
            '/' => $res * $l,
            '*' => $res / $l,
        };
        $x = $r;

    } elseif (preg_match('/^\d+$/', $r)) {
        // right side is the number...
        $r = intval($r);
        $res = match ($op) {
            '+' => $res - $r,
            '-' => $res + $r,
            '/' => $res * $r,
            '*' => $res / $r,
        };
        $x = $l;
    } else {
        throw new Exception('unexpected x: '. $x);
    }
    unset($matches, $matches2);
}

echo sprintf('Result %d in (%s sec)%s',  $res, round(microtime(true)-$s,5), PHP_EOL);
