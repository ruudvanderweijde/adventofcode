<?php

function assertSame(mixed $expected, mixed $actual) {
    assert($expected === $actual, "Expected [$expected] does not equal actual [$actual]");
}