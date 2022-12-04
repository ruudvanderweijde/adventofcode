<?php
$score = 0;
if ($handle = fopen("input", "r")) {
    while (($line = fgets($handle)) !== false) {
        $score += (int) match(explode(' ', trim($line))[1]) { 'X' => '1', 'Y' => '2', 'Z' => '3' }
            + (int) match (trim($line)) { 'A X', 'B Y', 'C Z' => '3', 'A Z', 'C Y', 'B X' => '0', default => '6' };
    }
    fclose($handle);
}
var_dump($score);
