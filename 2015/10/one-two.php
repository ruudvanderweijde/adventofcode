<?php
$s = microtime(true);
$input = '1321131112';

function lookAndSay(string $input): string {
    $ret = '';
    preg_match_all('/(\d)\1*/', $input, $matches);
    foreach ($matches[0] as $match) {
        $ret .= strlen($match) . $match[0];
    }
    return $ret;
}

assert('11', lookAndSay('1'));
assert('21', lookAndSay('11'));
assert('1211', lookAndSay('21'));
assert('111221', lookAndSay('1211'));
assert('312211', lookAndSay('111221'));
assert('11131221133112', lookAndSay('1321131112'));

$i = 0;
while (++$i <= 50) {
    echo "$i/50\r";
    $input = lookAndSay($input);
    if ($i === 40 || $i === 50) {
        echo strlen($input) . ' in ('.round(microtime(true)-$s,5).')';
        echo PHP_EOL;
    }
}
