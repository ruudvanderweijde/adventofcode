<?php

$elves = [];
$index = 1;
$counter = 1;

if ($handle = fopen("input", "r")) {
    while (($line = fgets($handle)) !== false) {
        if (trim($line) === "") $index += 1;
        else $elves[$index] = ($elves[$index] ?? 0) + (int) $line;
    }

    fclose($handle);
}

asort($elves, SORT_NUMERIC);

var_dump('first answer: ' . $firstAnswer = array_pop($elves));
var_dump('second answer: ' . $firstAnswer + array_pop($elves) + array_pop($elves));
