<?php

class Line {
    private const OPENING_CHARS = '[{(<';
    private const POINTS = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
    /** @var Chunk[] */
    private array $openChunks = [];
    public string $error = '';
    public int $points = 0;
    public function __construct(string $input) {
        foreach (str_split($input) as $i => $char) {
            if (str_contains(self::OPENING_CHARS, $char)) {
                $this->openChunks[] = new Chunk($char);
            } else {
                $end = array_pop($this->openChunks);
                if ($end->closeWith !== $char) {
                    $this->error = sprintf("Expected '%s', but found '%s' instead at pos '%d'\n%s\n%s\n", $end->closeWith, $char, $i, $input, str_repeat('-', $i) . '^');
                    $this->points = self::POINTS[$char];
                    break;
                };
            }
        }
    }
}
class Chunk {
    private const CLOSING_CHARS = ['[' => ']', '{' => '}', '(' => ')', '<' => '>'];
    public string $closeWith;
    public function __construct(string $open)
    {
        $this->closeWith = self::CLOSING_CHARS[$open];
    }
}

echo array_sum(
    array_map(
        fn ($line) => (new Line($line))->points,
        array_map('rtrim', file($argv[1] ?? 'input-test'))
    )
);
echo PHP_EOL;

if ($argv[2] ?? false) {
    foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $x => $line) {
        $line = new Line($line);
        echo $line->error;
    }
}
