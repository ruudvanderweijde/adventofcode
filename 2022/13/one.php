<?php

class Pair {
    private array $left;
    private array $right;

    public function __construct(string $left, string $right) {
        $this->left = json_decode($left, true);
        $this->right = json_decode($right, true);
    }

    public function inRightOrder(): bool {
        return $this->compare($this->left, $this->right) === -1;
    }

    private function compare($left, $right): int {
        if (is_int($left) && is_int($right)) { return $left <=> $right; }
        if (is_int($left)) { $left = [$left]; }
        if (is_int($right)) { $right = [$right]; }

        for($i=0; $i<min(count($left),count($right)); ++$i) {
            if (($compare = $this->compare($left[$i], $right[$i])) !== 0) {
                return $compare;
            }
        }

        return count($left) <=> count($right);
    }
}

$pairs = array_filter(
    array_map(
        fn(string $lines) => (new Pair(...explode(PHP_EOL, $lines)))->inRightOrder(),
        explode(PHP_EOL . PHP_EOL, rtrim(file_get_contents($argv[1] ?? 'input-test')))
    )
);

if (($argv[2] ?? "") === "assert") {
    assert([true, true, false, true, false, true, false, false] === $pairs);
}

$rightOrder = array_filter($pairs);
echo count($rightOrder) + array_sum(array_keys($rightOrder));
echo PHP_EOL;
