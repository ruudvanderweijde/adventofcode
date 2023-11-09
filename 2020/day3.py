def part1(filename):
    grid = read_input(filename)
    return getCount(grid, 3, 1)


def part2(filename):
    grid = read_input(filename)
    return (
        getCount(grid, 1, 1) *
        getCount(grid, 3, 1) *
        getCount(grid, 5, 1) *
        getCount(grid, 7, 1) *
        getCount(grid, 1, 2)
    )


def getCount(grid, _x, _y):
    x, y = 0, 0
    count = 0
    while y < len(grid):
        if grid[y][x] == "#":
            count += 1
        y += _y
        x += _x
        x %= len(grid[1])
    return count


def read_input(filename):
    with open(filename) as file:
        return [[*line.rstrip()] for line in file]


def matchPart1(item):
    start, end, pattern, password = item
    return int(start) <= password.count(pattern) <= int(end)


def matchPart2(item):
    start, end, pattern, password = item
    return (password[int(start)-1] == pattern) ^ (password[int(end)-1] == pattern)


assert 7 == part1("test/day3.txt")
print("Day 3, Part 1:", part1("input/day3.txt"))

assert 336 == part2("test/day3.txt")
print("Day 3, Part 2:", part2("input/day3.txt"))
