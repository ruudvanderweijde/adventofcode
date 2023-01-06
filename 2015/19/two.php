<?php
unset($_SERVER);
$s = microtime(true);

[$rawReplacements, $medicine] = explode(PHP_EOL.PHP_EOL, trim(file_get_contents('input')));
$replacements = [];
foreach (explode(PHP_EOL, $rawReplacements) as $replacement) {
    [$k, $v] = explode(' => ', trim($replacement));
    $replacements[$v] = $k;
}
unset($rawReplacements, $replacement, $k, $v);

$string = $medicine;
$replaces = 0;
$count = 0;
while ($string !== 'e') {
    $reset = false;
    $newString = str_replace(array_keys($replacements), array_values($replacements), $string, $replaces);
    if ($string === $newString) {
        shuffle_assoc($replacements);
        $string = $medicine;
        $count = 0;
        continue;
    }
    $count += $replaces;
    $string = $newString;
}
echo PHP_EOL;
echo $count . ' in (' . round(microtime(true)-$s, 3) . ' sec)' . PHP_EOL;


function shuffle_assoc(&$array) {
    $keys = array_keys($array);

    shuffle($keys);

    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }

    $array = $new;

    return true;
}