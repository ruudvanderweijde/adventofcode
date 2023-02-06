<?php

function visitPipes(array $pipes, int $start = 0): array
{
    $visited = [];
    $queue = [$start];

    while (count($queue) > 0) {
        $pipe = array_shift($queue);
        $visited[$pipe] = 1;

        foreach ($pipes[$pipe] as $next) {
            if (!array_key_exists($next, $visited)) {
                $queue[] = $next;
            }
        }
    }

    return $visited;
}

function createPipes(array $input): array
{
    $pipes = [];
    foreach ($input as $line) {
        [$l, $r] = explode(' <-> ', $line);
        $pipes[intval($l)] = array_map('intval', explode(', ', $r));
    }
    return $pipes;
}

assert(6 === count(visitPipes(createPipes(file('12.test', FILE_IGNORE_NEW_LINES)))));

$s = microtime(true);
$pipes = createPipes(file('12.input', FILE_IGNORE_NEW_LINES));
printf("part1: count=%d (in %3f sec)\n", count(visitPipes($pipes)), microtime(true)-$s);

$s = microtime(true);
$res = [];
foreach($pipes as $pipe => $_) {
    $_res = array_keys(visitPipes($pipes, $pipe));
    sort($_res);
    $res[$pipe] = join(',', $_res);
}
printf("part2: groups=%d (in %3f sec)\n", count(array_unique($res)), microtime(true)-$s);

