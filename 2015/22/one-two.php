<?php
$s = microtime(true);
const BOSS_HIT_POINTS = 71;
const BOSS_DAMAGE = 10;
const PLAYER_HIT_POINTS = 50;
const PLAYER_MANA = 500;
const HARD_MODE = false;

class State {
    public function __construct(
        public int $playerMana = 0,
        public int $totalMana = 0,
        public int $playerHit = 0,
        public int $bossHit = 0,
        public int $shieldLeft = 0,
        public int $poisonLeft = 0,
        public int $rechargeLeft = 0,
    ) {}

}
abstract class Spell {
    public function __construct(public int $cost) {}
    abstract public function modifier(State &$s): void;
    abstract public function condition(State $s): bool;
}
final class MagicMissile extends Spell {
    // Magic Missile costs 53 mana. It instantly does 4 damage.
    public function __construct() { parent::__construct(53); }
    public function modifier(State &$s): void { $s->bossHit -= 4; }
    public function condition(State $s): bool { return true; }
}
final class Drain extends Spell {
    // Drain costs 73 mana. It instantly does 2 damage and heals you for 2 hit points.
    public function __construct() { parent::__construct(73); }
    public function modifier(State &$s): void {  $s->bossHit -= 2; $s->playerHit += 2; }
    public function condition(State $s): bool { return true; }
}
final class Shield extends Spell {
    // Shield costs 113 mana. It starts an effect that lasts for 6 turns. While it is active, your armor is increased by 7.
    public function __construct() { parent::__construct(113); }
    public function modifier(State &$s): void { $s->shieldLeft = 6; }
    public function condition(State $s): bool { return $s->shieldLeft == 0; }
}
final class Poison extends Spell {
    // Poison costs 173 mana. It starts an effect that lasts for 6 turns. At the start of each turn while it is active, it deals the boss 3 damage.
    public function __construct() { parent::__construct(173); }
    public function modifier(State &$s): void { $s->poisonLeft = 6; }
    public function condition(State $s): bool { return $s->poisonLeft == 0; }
}
final class Recharge extends Spell {
    // Recharge costs 229 mana. It starts an effect that lasts for 5 turns. At the start of each turn while it is active, it gives you 101 new mana.
    public function __construct() { parent::__construct(229); }
    public function modifier(State &$s): void { $s->rechargeLeft = 5; }
    public function condition(State $s): bool { return $s->rechargeLeft == 0; }
}

/** @var Spell[] $spells */
$spells = [new MagicMissile(), new Drain(), new Shield(), new Poison(), new Recharge()];

function applyEffects(State &$state): void {
    if ($state->poisonLeft > 0) {
        $state->bossHit -= 3;
        --$state->poisonLeft;
    }

    if ($state->rechargeLeft > 0) {
        $state->playerMana += 101;
        --$state->rechargeLeft;
    }
}

$initialState = new State(playerMana: PLAYER_MANA, playerHit: PLAYER_HIT_POINTS, bossHit: BOSS_HIT_POINTS);

$queue = [$initialState];
$min = INF;
while (count($queue) > 0) {
    printf("Queue size=%d, min=%d\r", count($queue), $min);
    $state = array_shift($queue);
    applyEffects($state);
    if ($state->shieldLeft > 0) {
        --$state->shieldLeft;
    }
    if ($state->bossHit <= 0) {
        $min = min($min, $state->totalMana);
        continue;
    }
    if (HARD_MODE) {
        if (--$state->playerHit <= 0) {
            continue;
        }
    }
    shuffle($spells);
    foreach ($spells as $spell) {
        if ($spell->cost <= $state->playerMana && $state->totalMana + $spell->cost < $min && $spell->condition($state)) {
            $nextState = clone $state;
            $nextState->playerMana -= $spell->cost;
            $nextState->totalMana += $spell->cost;
            $spell->modifier($nextState);
            if ($nextState->bossHit <= 0) {
                # boss dead
                $min = min($min, $nextState->totalMana);
            } else {
                # boss turn
                applyEffects($nextState);
                if ($nextState->bossHit <= 0) {
                    # boss dead on their turn
                    $min = min($min, $nextState->totalMana);
                    continue;
                }
                if ($nextState->shieldLeft > 0) {
                    $nextState->playerHit -= max(BOSS_DAMAGE-7, 1);
                    --$nextState->shieldLeft;
                } else {
                    $nextState->playerHit -= BOSS_DAMAGE;
                }

                if ($nextState->playerHit > 0) {
                    $queue[] = $nextState;
                }
            }
        }
    }
}

echo PHP_EOL;
echo $min;
echo ' in ' . round(microtime(true)-$s,3) . ' sec' . PHP_EOL;
//Hit Points: 71
//Damage: 10

# 564 is too low
# 773 is too low