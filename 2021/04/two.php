<?php

$input = explode(PHP_EOL . PHP_EOL, file_get_contents($argv[1]));
$instructions = explode(',', array_shift($input));

class Number
{
    public function __construct(
        public string $x,
        public string $y,
        public int    $val,
        public bool   $checked = false,
    )
    {
    }
}

class Card
{
    /** @var Number[] */
    private array $numbers = [];

    public function __construct(string $in)
    {
        foreach (explode(PHP_EOL, $in) as $x => $row) {
            preg_match('/(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/', $row, $matches);

            foreach (array_slice($matches, 1, 5) as $y => $number) {
                $this->numbers[$number] = new Number($x, $y, (int)$number);
            }
        }
    }

    public function check(int $number): bool
    {
        if (!isset($this->numbers[$number])) {
            return false;
        }

        $this->numbers[$number]->checked = true;

        return $this->hasBingo();
    }

    private function hasBingo(): bool
    {
        $x = [];
        $y = [];
        foreach ($this->numbers as $number) {
            if ($number->checked) {
                $x[$number->x] = ($x[$number->x] ?? 0) + 1;
                $y[$number->y] = ($y[$number->y] ?? 0) + 1;
            }
        }

        return in_array("5", $x) || in_array("5", $y);
    }

    public function getScore(int $number): int
    {
        return $number * array_sum(
                array_map(fn(Number $n): int => !$n->checked ? $n->val : 0, $this->numbers)
            );
    }
}

$cards = array_map(fn(string $in) => new Card(rtrim($in)), $input);
foreach ($instructions as $number) {
    foreach ($cards as $k => $card) {
        if ($card->check($number)) {
            if (count($cards) === 1) {
                echo $card->getScore($number) . PHP_EOL;
            }
            unset($cards[$k]);
        }
    }
}
