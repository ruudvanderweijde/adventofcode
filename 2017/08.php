<?php
require_once('../lib/partEnum.php');

function jumpInstructions(string $file): int
{
    global $part;
    $input = file($file, FILE_IGNORE_NEW_LINES);
    $operations = [];
    $registers = [];
    $max = PHP_INT_MIN;
    foreach ($input as $line) {
        if (!preg_match('/^(\w+) (inc|dec) ([0-9-]+) if (\w+) (>|<|>=|<=|==|!=) ([0-9-]+)$/', $line, $matches)) {
            throw new Exception('Unsupported input: ' . $line);
        }
        array_shift($matches);
        $registers[$matches[0]] = $registers[$matches[3]] = 0;
        $operations[] = $matches;
        unset($line, $matches);
    }
    unset($input);

    foreach ($operations as $op) {
        if (match ($op[4]) {
            '==' => $registers[$op[3]] == intval($op[5]),
            '!=' => $registers[$op[3]] != intval($op[5]),
            '>=' => $registers[$op[3]] >= intval($op[5]),
            '<=' => $registers[$op[3]] <= intval($op[5]),
            '>' => $registers[$op[3]] > intval($op[5]),
            '<' => $registers[$op[3]] < intval($op[5]),
        }) {
            if ($op[1] === 'inc') {
                $registers[$op[0]] += intval($op[2]);
            } else {
                $registers[$op[0]] -= intval($op[2]);
            }
            $max = max($max, max($registers));
        }
    }
    return $part === Part::ONE ? max($registers) : $max;
}


$part = Part::ONE;
assert(1 === jumpInstructions('08.test'));

$s = microtime(true);
printf("part1: max=%d (in %3f sec)\n", jumpInstructions('08.input'), microtime(true)-$s);

$part = Part::TWO;
assert(10 === jumpInstructions('08.test'));

$s = microtime(true);
printf("part2: max=%d (in %3f sec)\n", jumpInstructions('08.input'), microtime(true)-$s);
