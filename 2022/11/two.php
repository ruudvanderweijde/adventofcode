<?php

$filename = $argv[1] ?? 'input-test';

class Collection {
    /** @var Monkey[]  */
    public array $monkeys = [];

    public function __construct(string $input) {
        $this->monkeys = array_map(fn (string $in) => new Monkey($in), explode(PHP_EOL.PHP_EOL, $input));
    }

    public function inspect(): void {
        foreach($this->monkeys as $monkeyId => $monkey) {
            foreach($monkey->items as $itemId => $item) {
                ++$monkey->inspections;
                $item = $monkey->operation->execute($item);
                $item %= array_product(array_map(fn (Monkey $m) => $m->testDivisibleBy, $this->monkeys));

                $moveTo = $item % $monkey->testDivisibleBy === 0 ? $monkey->whenTrue : $monkey->whenFalse;
                $this->monkeys[$moveTo]->items[] = $item;
                unset($this->monkeys[$monkeyId]->items[$itemId]);
            }
        }
    }

    public function print(): void {
        foreach($this->monkeys as $monkey) {
            echo "Monkey [" . $monkey->id . "]: " . implode(', ', $monkey->items) . ' (inspections = ' . $monkey->inspections . ')' . PHP_EOL;
        }
    }
}

class Operation {
    public string $l;
    public string $r;
    public string $op;

    public function __construct(string $input) {
        [$this->l, $this->op, $this->r] = explode(' ', $input);
    }

    public function execute(int $old): int {
        $r = self::toNumber($this->r, $old);
        $l = self::toNumber($this->l, $old);

        return intval(match($this->op) {
            '+' => $l + $r,
            '*' => $l * $r,
        });
    }

    private static function toNumber(string $in, int $old): int {
        return intval(str_replace('old', $old, $in));
    }
}
class Monkey {
    public int $id;
    public array $items;
    public Operation $operation;
    public int $testDivisibleBy;
    public int $whenTrue;
    public int $whenFalse;
    public int $inspections = 0;

    public function __construct(string $input) {
        [$id, $start, $operation, $test, $whenTrue, $whenFalse] = explode(PHP_EOL, $input);
        $this->id = self::getNumber($id);
        $this->items = array_map('intval', explode(', ', str_replace('  Starting items: ', '', $start)));
        $this->operation = new Operation(str_replace('  Operation: new = ', '', $operation));
        $this->testDivisibleBy = self::getNumber($test);
        $this->whenTrue = self::getNumber($whenTrue);
        $this->whenFalse = self::getNumber($whenFalse);
    }

    private static function getNumber(string $input): int
    {
        return intval(preg_replace('/[^0-9]/', '', $input));
    }
}

$assertions = [
    1 => [2, 4, 3, 6],
    20 => [99, 97, 8, 103],
    1000 => [5204, 4792, 199, 5192],
    2000 => [10419, 9577, 392, 10391],
    3000 => [15638, 14358, 587, 15593],
    4000 => [20858, 19138, 780, 20797],
    5000 => [26075, 23921, 974, 26000],
    6000 => [31294, 28702, 1165, 31204],
    7000 => [36508, 33488, 1360, 36400],
    8000 => [41728, 38268, 1553, 41606],
    9000 => [46945, 43051, 1746, 46807],
    10000 => [52166, 47830, 1938, 52013],
];

$monkeys = new Collection(file_get_contents($filename));
for ($i=0; $i < $rounds = 10000; ++$i) {
    $monkeys->inspect();
    // print
    if (($argv[2] ?? false) === "print" && in_array($i+1, array_keys($assertions))) {
        echo "> Round " . $i+1;
        echo PHP_EOL;
        $monkeys->print();
        echo PHP_EOL;
    }
    // assert
    if (($argv[3] ?? false) === "assert" && in_array($i+1, array_keys($assertions))) {
        $array_map = array_map(fn(Monkey $m) => $m->inspections, $monkeys->monkeys);
        if ($assertions[$i+1] != $array_map) {
            return sprintf('Iteration %d: [%s] did not match expected [%s]', $i+1, join(', ', $assertions[$i+1]), join(', ', $array_map));
        }
    }
}

$inspections = array_map(fn (Monkey $m) => $m->inspections, $monkeys->monkeys);
rsort($inspections);
echo array_product(array_slice($inspections, 0, 2));
echo PHP_EOL;
