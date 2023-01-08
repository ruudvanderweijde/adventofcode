<?php
$s = microtime(true);
$weapons = [['Dagger', 8, 4, 0], ['Shortsword', 10, 5, 0], ['Warhammer', 25, 6, 0], ['Longsword', 40, 7, 0], ['Greataxe', 74, 8, 0]];
$armors = [['Dummy', 0, 0, 0], ['Leather', 13, 0, 1], ['Chainmail', 31, 0, 2], ['Splintmail', 53, 0, 3], ['Bandedmail', 75, 0, 4], ['Platemail', 102, 0, 5]];
$rings = [['Damage +1', 25, 1, 0], ['Damage +2', 50, 2, 0], ['Damage +3', 100, 3, 0], ['Defense +1', 20, 0, 1], ['Defense +2', 40, 0, 2], ['Defense +3', 80, 0, 3]];

$boss = [100, 8, 2]; // hit points, damage, armor

$options = [];
foreach ($weapons as $weapon) {
    $options[] = [$weapon]; # only this weapon, no armor, no rings
    foreach ($armors as $armor) {
        $options[] = [$weapon, $armor]; # weapon, no armor, one rings
        foreach ($rings as $k => $ring) {
            $options[] = [$weapon, $armor, $ring]; # weapon, no armor, one rings
            foreach ($rings as $_k => $_ring) {
                if ($_k > $k) {
                    $options[] = [$weapon, $armor, $ring, $_ring]; # weapon + armor, no rings
                }
            }
        }
    }
}

function winFight(array $items, array $boss): bool {
    $player = [100, array_sum(array_column($items, 2)), array_sum(array_column($items, 3))];
    while (true) {
        // player hits: player damage - boss armor
        $boss[0] -= max($player[1] - $boss[2], 1);
        if ($boss[0] <= 0) { return true; }
        $player[0] -= max($boss[1] - $player[2], 1);
        if ($player[0] <= 0) { return false; }
    }
}

$winningFights = array_filter($options, fn(array $o) => winFight($o, $boss));
$sumCosts = fn(array $o) => array_sum(array_column($o, 1));
$costPerFight = array_map($sumCosts, $winningFights);

echo min($costPerFight);
echo ' in ' . round(microtime(true)-$s,3) . ' sec' . PHP_EOL;

$losingFights = array_filter($options, fn(array $o) => !winFight($o, $boss));
echo max(array_map($sumCosts, $losingFights));
echo ' in ' . round(microtime(true)-$s,3) . ' sec' . PHP_EOL;
