<?php

class Line {
    private const OPENING_CHARS = '[{(<';
    private const POINTS = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
    private const SCORE_MAP = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
    /** @var Chunk[] */
    private array $openChunks = [];
    public string $missing = '';
    public string $error = '';
    public int $points = 0;
    public int $score = 0;
    public function __construct(string $input) {
        foreach (str_split($input) as $i => $char) {
            if (str_contains(self::OPENING_CHARS, $char)) {
                $this->openChunks[] = new Chunk($char);
            } else {
                $end = array_pop($this->openChunks);
                if ($end->closeWith !== $char) {
                    $this->error = sprintf("Expected '%s', but found '%s' instead at pos '%d'\n%s\n%s\n", $end->closeWith, $char, $i, $input, str_repeat('-', $i) . '^');
                    $this->points = self::POINTS[$char];
                    return;
                };
            }
        }
        while ($last = array_pop($this->openChunks)) {
            $this->score *= 5;
            $this->score += self::SCORE_MAP[$last->closeWith];
            $this->missing .= $last->closeWith;
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

$scores = array_filter(
    array_map(
        fn ($line) => (new Line($line))->score,
        array_map('rtrim', file($argv[1] ?? 'input-test'))
    ),
    fn (int $score) => $score > 0
);
sort($scores);
echo $scores[floor(count($scores)/2)];

echo PHP_EOL;

if ($argv[2] ?? false) {
    foreach (array_map('rtrim', file($argv[1] ?? 'input-test')) as $x => $line) {
        $line = new Line($line);
        if ($line->score) {
            echo $line->missing;
            echo " -> $line->score total points";
            echo PHP_EOL;
        }
    }
}
