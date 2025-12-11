from itertools import batched
from math import ceil

def main(filename, part):
    input = read_input(filename)
    invalid = 0
    for i in input:
        l, r = i.split('-')
        for n in range(int(l), int(r)+1):
            if part == 1 and is_invalid_part1(n):
                invalid += n
            if part == 2 and is_invalid_part2(n):
                invalid += n
    return invalid


def is_invalid_part1(n):
    if len(str(n)) % 2 != 0:
        return False

    s = str(n)
    l = s[:int(len(s) / 2)]
    r = s[int(len(s) / 2):]
    return l == r


def is_invalid_part2(n):
    s = str(n)
    l = len(s)
    if l < 2:
        return False
    for r in range(1, ceil(l / 2)+1):
        if l % r != 0:
            # if batches are not equal in size, don't bother
            continue
        if all_same(list(batched(s ,r))):
            return True


    return False


def all_same(items):
    return all(x == items[0] for x in items)


def read_input(filename):
    with open(filename) as file:
        return file.read().split(',')


assert 1227775554 == main("test/day2.txt", 1)
print("Day 2, Part 1:", main("input/day2.txt", 1))

assert 4174379265 == main("test/day2.txt", 2)
print("Day 2, Part 2:", main("input/day2.txt", 2))