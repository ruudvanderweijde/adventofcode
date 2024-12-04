dirs = [
    (-1, 0),  # N
    (-1, -1), # NE
    (0, 1),   # E
    (1, 1),   # SE
    (1, 0),   # S
    (1, -1),   # SW
    (0, -1),  # W
    (-1, 1),  # NW
]


def part1(filename):
    grid = read_input(filename)
    count = 0
    size = len(grid)
    assert len(grid) == len(grid[0])

    for x, ys in enumerate(grid):
        for y, v in enumerate(ys):
            for dx, dy in dirs:
                x_, y_, v_ = x, y, v
                match = True
                for char in "XMAS":
                    if v_ == char:
                        x_ += dx
                        y_ += dy
                        if not (0 <= x_ < size and 0 <= y_ < size):
                            continue
                        v_ = grid[x_][y_]
                    else:
                        match = False
                        break
                if match:
                    count += 1

    return count


def part2(filename):
    grid = read_input(filename)
    count = 0
    size = len(grid)
    assert len(grid) == len(grid[0])

    for x, ys in enumerate(grid):
        for y, v in enumerate(ys):
            if not (1 <= x < size-1 and 1 <= y < size-1):
                continue
            if v == "A" and grid[x - 1][y - 1] + grid[x + 1][y - 1] + grid[x + 1][y + 1] + grid[x - 1][y + 1] in ["MMSS", "SMMS", "SSMM", "MSSM"]:
                count += 1
    return count


def read_input(filename):
    with open(filename) as file:
        return [[j for j in i.rstrip()] for i in file.readlines()]


assert 18 == part1("test/day4.txt")
print("Day 4, Part 1:", part1("input/day4.txt"))

assert 9 == part2("test/day4.txt")
print("Day 4, Part 2:", part2("input/day4.txt"))