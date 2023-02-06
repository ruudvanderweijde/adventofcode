<?php

function assertSame(mixed $expected, mixed $actual) {
    if (is_array($expected) && is_array($actual)) {
        $expected = json_encode($expected);
        $actual = json_encode($actual);
    }
    assert($expected === $actual, "Expected [$expected] does not equal actual [$actual]");
}