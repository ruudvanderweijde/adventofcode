<?php
/**
 * A Y  # Y = DRAW  -> SO X (rock = 1 + draw = 3)
 * B X  # X = LOOSE -> SO X
 * C Z  # Z = WIN   -> SO
 */
$score = 0;
if ($handle = fopen("input", "r")) {
    while (($line = fgets($handle)) !== false) {
        $score += match (trim($line)) {
            'A X' => 0 + 3,
            'A Y' => 3 + 1,
            'A Z' => 6 + 2,
            'B X' => 0 + 1,
            'B Y' => 3 + 2,
            'B Z' => 6 + 3,
            'C X' => 0 + 2,
            'C Y' => 3 + 3,
            'C Z' => 6 + 1
        };
    }
    fclose($handle);
}
var_dump($score);
