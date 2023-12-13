import time
from copy import copy


def part1(filename):
    grids = get_grids(filename)
    total = 0
    for grid in grids:
        flipped_grid = [''.join(i) for i in zip(*grid)]
        total += sum(get_rows(grid)[:1])*100
        total += sum(get_rows(flipped_grid)[:1])
    return total


def part2(filename):
    grids = get_grids(filename)
    total = 0
    for grid in grids:
        flipped_grid = [''.join(i) for i in zip(*grid)]
        ignore_rows = get_rows(grid)
        ignore_cols = get_rows(flipped_grid)

        for i in range(len(grid)):
            for j in range(len(grid[i])):
                new_grid = copy(grid)
                new_str = '#' if new_grid[i][j] == '.' else '.'

                new_grid[i] = grid[i][:j] + new_str + grid[i][j + 1:]
                new_flipped_grid = [''.join(x) for x in zip(*new_grid)]

                rows = get_rows(new_grid)
                rows_filtered = [x for x in rows if x not in ignore_rows]
                if rows_filtered:
                    total += sum(rows_filtered[:1]) * 100
                    break

                cols = get_rows(new_flipped_grid)
                cols_filtered = [x for x in cols if x not in ignore_cols]
                if cols_filtered:
                    total += sum(cols_filtered[:1])
                    break
            else:
                continue
            break
    return total


def get_rows(grid):
    rev_grid = list(reversed(grid))
    dupe_row = []
    for i in range(1, len(grid)):
        to_check = min(i, len(grid) - i)
        if rev_grid[-i:][:to_check] == grid[i:][:to_check]:
            dupe_row.append(i)
    return dupe_row


def get_grids(filename):
    with open(filename) as file:
        return [i.split() for i in file.read().rstrip().split('\n\n')]


assert 405 == part1("test/day13.txt")
st = time.time()
print("Day 13, Part 1:", part1("input/day13.txt"), " in %s seconds " % (time.time() - st))

assert 400 == part2("test/day13.txt")
st = time.time()
print("Day 13, Part 2:", part2("input/day13.txt"), " in %s seconds " % (time.time() - st))
