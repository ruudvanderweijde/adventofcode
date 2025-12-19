import time
from math import prod
from typing import Any


def main(filename, part):
    return part1(filename) if part == 1 else part2(filename)


def part1(filename) -> int | Any:
    grid = read_input1(filename)
    total = 0
    for i in range(len(grid[0])):
        numbers = []
        for j in range(len(grid)):
            item = grid[j][i]
            if item == '+':
                total += sum(numbers)
                break
            if item == '*':
                total += prod(numbers)
                break
            numbers.append(int(item))
    return total


def read_input1(filename):
    with open(filename) as file:
        return [l.split() for l in file.readlines()]


def part2(filename):
    total = 0
    raw = read_input2(filename)
    i = len(max(raw, key=len))
    l = []
    while i > 0:
        i -= 1
        item = ''
        for j in range(len(raw)):
            try:
                char = raw[j][i]
            except IndexError:
                char = ''
            if char in ['+', '*']:
                l.append(int(item))
                if char == '+':
                    total += sum(l)
                if char == '*':
                    total += prod(l)
                l = []
                item = ''
                break
            item += char
        if item.strip() != '':
            l.append(int(item))

    return total

def read_input2(filename):
    with open(filename) as file:
        return [l.rstrip() for l in file.readlines()]


start = time.time()
assert 4277556 == main("test/day6.txt", 1)
print("day 6, Part 1:", main("input/day6.txt", 1))
print("Duration: ", time.time()-start)

start = time.time()
assert 3263827 == main("test/day6.txt", 2)
print("day 6, Part 2:", main("input/day6.txt", 2))
print("Duration: ", time.time()-start)