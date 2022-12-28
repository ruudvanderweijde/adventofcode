<?php
$start = microtime(true);

function manhattan(array $from, array $to): int {
    [$fromY, $fromX, $toY, $toX] = [...$from, ...$to];
    return abs($fromY - $toY) + abs($fromX - $toX);
}

$sensors = array_map(
    fn (array $in) => [$in[1], $in[0], manhattan([$in[1], $in[0]], [$in[3], $in[2]])],
    array_map(
        fn(string $str) => array_map('intval', explode(',', trim(preg_replace('/[^0-9-]+/', ',', $str), ','))),
        file($argv[1] ?? 'input-test')
    )
);
$min = intval(($argv[2] ?? 0));
$max = intval(($argv[3] ?? 20));
$iterator = 0;
for ($y=$min; $y<= $max; $y++) {
    for ($x=$min; $x<=$max; $x++) {
        if (++$iterator % 250 === 0) echo "$y / $max || $x / $max\r";
        $found = false;
      foreach($sensors as [$sy, $sx, $distance]) {
            $xDiff = abs($x - $sx);
            $yDiff = abs($y - $sy);
            $manhattanDistance = $xDiff + $yDiff;
            if ($manhattanDistance <= $distance) {
                $x = $sx + ($distance - $yDiff);
                $found = true;
                break;
            }
        }
      if (!$found) {
          echo PHP_EOL;
          echo "y=$y, x=$x";
          echo PHP_EOL;
          echo 4000000 * $x + $y;
          break 2;
      }
    }
  }

echo ' (in ' . round(microtime(true) - $start, 3) . ' sec)';
echo PHP_EOL;
