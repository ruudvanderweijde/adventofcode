<?php

$s = microtime(true);

[$rawReplacements, $medicine] = explode(PHP_EOL.PHP_EOL, file_get_contents('input'));
$replacements = [];
foreach (explode(PHP_EOL, $rawReplacements) as $replacement) {
    [$k, $v] = explode(' => ', trim($replacement));
    $replacements[] = [$k => $v];
}

//$medicine = 'HOHOHO';
//$replacements = [['H' => 'HO'], ['H' => 'OH'], ['O' => 'HH']];

$result = [];
foreach ($replacements as $replacement) {
    $val = reset($replacement);
    $key = key($replacement);

    $offset = 0;
    while(false !== $pos = strpos($medicine, $key, $offset)) {
        $result[] = substr_replace($medicine, $val, $pos, strlen($key));
        $offset = $pos+1;
    }

}
echo count($result) . PHP_EOL;
echo count(array_unique($result)) . ' in (' . round(microtime(true)-$s, 3) . ' sec)' . PHP_EOL;

