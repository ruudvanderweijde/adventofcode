<?php
$s = microtime(true);

function nextPassword(string $password): string
{
    $illegalChars = ['i', 'o', 'l'];
    while (true) {
        echo "$password\r";
        // Increment password
        ++$password;

        // Check if password contains the letters i, o, or l
        foreach ($illegalChars as $illegalChar) {
            if (false !== ($pos = strpos($password, $illegalChar))) {
                $password = substr($password, 0, $pos) . ++$illegalChar . str_repeat('a', strlen($password) - ($pos + 1));
            }
        }
        // Check if password contains at least two different, non-overlapping pairs of letters
        preg_match_all('/(.)\1/', $password, $matches);
        if (count($matches[0]) < 2) {
            continue;
        }

        // Check if password contains an increasing straight of at least three letters
        for ($i = 0; $i < strlen($password) - 2; $i++) {
            if (ord($password[$i]) === ord($password[$i + 1]) - 1 && ord($password[$i + 1]) === ord($password[$i + 2]) - 1) {
                // Password contains an increasing straight of at least three letters
                break 2;
            }
        }
    }
    return $password;
}

$password = 'hxbxwxba';
$password = nextPassword($password);
echo "Next password is: $password" . ' in (' .round(microtime(true)-$s,5).')' . PHP_EOL;
$password = nextPassword($password);
echo "Next password is: $password" . ' in (' .round(microtime(true)-$s,5).')' . PHP_EOL;