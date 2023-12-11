import time
from itertools import combinations


def main(filename, explosion):
    return sum([manhattan(s, e) for s, e in (get_pairs(filename, explosion))])


def manhattan(a, b):
    return sum(abs(val1 - val2) for val1, val2 in zip(a, b))


def get_pairs(filename, explosion):
    with (open(filename) as file):
        grid = [[j for j in i] for i in file.read().rstrip().split('\n')]

        empty_rows = []
        empty_cols = []
        galaxies = []

        for y, r in enumerate(grid):
            for x, c in enumerate(r):
                if c == '#':
                    galaxies.append((y, x))

        for i in range(len(grid)):
            if all([_r == '.' for _r in grid[i]]):
                empty_rows.append(i)
            if all(_c[i] == '.' for _c in grid):
                empty_cols.append(i)

        new_galaxies = []
        for y, x in galaxies:
            _y = (explosion-1) * sum(i < y for i in empty_rows)
            _x = (explosion-1) * sum(i < x for i in empty_cols)
            new_galaxies.append((y + _y, x + _x))

        return list(combinations(new_galaxies, 2))


assert 374 == main("test/day11.txt", explosion=2)
st = time.time()
print("Day 11, Part 1:", main("input/day11.txt", explosion=1), " in %s seconds " % (time.time() - st))

assert 1030 == main("test/day11.txt", explosion=10)
assert 8410 == main("test/day11.txt", explosion=100)
st = time.time()
print("Day 11, Part 2:", main("input/day11.txt", explosion=1000000), " in %s seconds " % (time.time() - st))
