<?php

final class Disc {
    public Disc|null $parent = null;
    public int $sum;
    public function __construct(readonly public int $weight, readonly public string $name, public array $children = []) {
        $this->sum = $this->weight;
    }
    public function addChild(Disc $child): void {
        $this->children[] = $child;
        $this->setSum();
    }
    public function setSum(): void {
        $this->sum = $this->weight + array_sum(array_map(fn(Disc $d) => $d->sum, $this->children));
        $parent = $this->parent;
        while ($parent !== null) {
            $parent->setSum();
            $parent = $parent->parent;
        }
    }
}

function createDisc(string $filename): Disc {
    return parseItem(...root($filename));
}

function root(string $filename): array {
    $input = file_get_contents($filename);
    preg_match_all('/[a-z]+/', $input, $matches);

    return [array_flip(array_count_values($matches[0]))[1], $input];
}

function parseItem(string $item, string $rawInput): Disc {
    preg_match("/$item \((\d+)\)( -> ([a-z, ]+))?/", $rawInput, $matches);
    $disc = new Disc(weight: intval($matches[1]), name: $item);
    if (!empty($matches[3] ?? [])) {
        foreach(explode(', ', $matches[3]) as $c) {
            $child = parseItem($c, $rawInput);
            $child->parent = $disc;
            $disc->addChild($child);
        };
    }
    return $disc;
}

function findImbalanced(Disc $disc): int {
    $getSums = fn(Disc $child) => $child->sum;
    $children = array_map($getSums, $disc->children);
    $uniqueValues = array_flip(array_count_values($children));
    if (count($uniqueValues) === 1) {
        // all children are even, let's calculate the desired value
        $values = array_flip(array_count_values(array_map($getSums, $disc->parent->children)));
        sort($values);
        $diff = $disc->sum === $values[0] ? $values[1] - $disc->sum : $values[0] - $disc->sum;
        return $disc->weight + $diff;
    }

    $oddOneOut = $uniqueValues[1];
    $childIndex = array_search($oddOneOut, $children);
    return findImbalanced($disc->children[$childIndex]);
}

assert('tknk' === root('07.test')[0]);
$s = microtime(true);
printf("part1: name=%s (in %3f sec)\n", root('07.input')[0], microtime(true)-$s);

assert(60 === findImbalanced(createDisc('07.test')));
$s = microtime(true);
printf("part2: value=%d (in %3f sec)\n", findImbalanced(createDisc('07.input')), microtime(true)-$s);
