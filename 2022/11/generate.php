<?php
foreach (getItems() as $item) {
    echo $item;
}

function getItems(): Generator {
    foreach (range(1,1000) as $item) {
        yield '\'intval(ceil($i/'.$item.'))\' => fn($i) => intval(ceil($i / '.$item.')),' . PHP_EOL;
        yield '\'intval(floor($i/'.$item.'))\' => fn($i) => intval(floor($i / '.$item.')),' . PHP_EOL;
        yield '\'intval(floor($i-'.$item.'))\' => fn($i) => intval(floor($i - '.$item.')),' . PHP_EOL;
        yield '\'intval(floor($i+'.$item.'))\' => fn($i) => intval(floor($i + '.$item.')),' . PHP_EOL;
        yield '\'intval(floor($i%'.$item.'))\' => fn($i) => intval(floor($i % '.$item.')),' . PHP_EOL;
    }
    foreach (range(0,10) as $x) {
        foreach (range(1,10) as $y) {
            foreach (range(0,10) as $z) {
                yield '\'intval(floor($i/('.$x.'-'.$z.')))-'.$y.')\' => fn($i) => intval(floor($i / ('.$x.'-'.$z.'))-'.$y.'),' . PHP_EOL;
                yield '\'intval(ceil($i/('.$x.'-'.$z.')))-'.$y.')\' => fn($i) => intval(ceil($i / ('.$x.'-'.$z.'))-'.$y.'),' . PHP_EOL;
                yield '\'intval(floor($i%('.$x.'-'.$z.')))-'.$y.')\' => fn($i) => intval(floor($i % ('.$x.'-'.$z.'))-'.$y.'),' . PHP_EOL;
            }
        }
    }
}
