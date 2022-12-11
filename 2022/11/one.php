<?php

$filename = $argv[1] ?? 'input-test';

class Collection {
    /** @var Monkey[]  */
    public array $monkeys = [];

    public function __construct(string $input) {
        $this->monkeys = array_map(
            fn (string $in) => new Monkey($in),
            explode(PHP_EOL.PHP_EOL, $input)
        );
    }

    public function inspect(): void {
        foreach($this->monkeys as $monkeyId => $monkey) {
            foreach($monkey->items as $itemId => $item) {
                ++$monkey->inspections;
                $item = intdiv($monkey->operation->execute($item), 3);

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
$monkeys = new Collection(file_get_contents($filename));
for ($i=0; $i < $rounds = 20; ++$i) {
    $monkeys->inspect();
    if ($argv[2] ?? false) {
        echo "> Round " . $i+1;
        echo PHP_EOL;
        $monkeys->print();
        echo PHP_EOL;
    }
}

$inspections = array_map(fn (Monkey $m) => $m->inspections, $monkeys->monkeys);
rsort($inspections);
echo array_product(array_slice($inspections, 0, 2));
echo PHP_EOL;
