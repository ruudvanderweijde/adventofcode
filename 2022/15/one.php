<?php
$start = microtime(true);
$debug = false;

function prnt(string $text, bool $always = false) {
   global $debug, $start;
   if ($always || $debug) {
       echo str_replace(PHP_EOL, "  \t(" . microtime(true) - $start . ')' . PHP_EOL, $text);
   }
}

class Vec { public function __construct(readonly public int $y, readonly public int $x) {} }
class Sensor {
    readonly private int $distance;
    public function __construct(readonly public Vec $pos, readonly public Vec $beacon) {
        $this->distance = $this->getDistance($pos, $beacon);
    }
    private function getDistance(Vec $from, Vec $to): int
    {
        return abs($from->x - $to->x) + abs($from->y - $to->y);
    }
    public function getPossibleNils(int $targetY): array {
        if (($this->pos->y - $this->distance) > $targetY || $targetY > ($this->pos->y + $this->distance)) {
            return [];
        }
        $diff = abs($targetY - $this->pos->y);
        return range($this->pos->x - ($this->distance-$diff), $this->pos->x + ($this->distance-$diff));
    }
}

class Field {
    public array $blockers = [];
    public array $nils = [];
    public function __construct(readonly array $in, readonly private int $targetY)
    {
        $array_map = array_map(fn(string $str) => array_map('intval', explode(',', trim(preg_replace('/[^0-9-]+/', ',', $str), ','))), $in);
        foreach ($array_map as $k => [$x1, $y1, $x2, $y2]) {
            prnt("Processing sensor " . ++$k . " of " . count($array_map) . "\n");
            $sensor = new Sensor(new Vec(y: $y1, x: $x1), new Vec(y: $y2, x: $x2));
            if ($nils = $sensor->getPossibleNils($this->targetY)) {
                $this->nils = array_unique(array_merge($this->nils, $nils));
                if ($y1 === $this->targetY) { $this->blockers[$x1] = $x1; }
                if ($y2 === $this->targetY) { $this->blockers[$x2] = $x2; }
            }
        }
    }
}

$debug = 'debug' === ($argv[3] ?? '');
$field = new Field(file($argv[1] ?? 'input-test'), intval(($argv[2] ?? '10')));
echo count($field->nils) - count($field->blockers);
echo ' (in ' . round(microtime(true) - $start, 3) . ' sec)';
echo PHP_EOL;
