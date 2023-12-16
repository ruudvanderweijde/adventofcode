import time

top = (-1, 0)
left = (0, -1)
right = (0, 1)
down = (1, 0)


class Colors:
    BOLD = '\033[1m'
    RED = '\033[91m'
    GREEN = '\033[92m'
    BACK_GREEN = '\033[42m'
    BACK_BLUE = '\033[44m'
    BACK_WHITE = '\033[47m'
    END = '\033[0m'


connections = {
    ".": [],
    "S": [top, left, right, down],
    "|": [top, down],
    "-": [left, right],
    "L": [top, right],
    "J": [top, left],
    "7": [down, left],
    "F": [down, right],
}

readable = {
    ".": ".",
    "S": "└",
    "|": "│",
    "-": "─",
    "L": "└",
    "J": "┘",
    "7": "┐",
    "F": "┌",
}


def part1(filename):
    start, grid = get_grid(filename)
    paths = get_paths(start, grid)

    return int((max([len(i) for i in paths]) - 1) / 2)


def part2(filename):
    start, grid = get_grid(filename)
    paths = get_paths(start, grid)
    size = max(sorted(paths[0], key=lambda x: max(x[0], x[1]), reverse=True)[0]) + 1
    count = 0
    for i in range(size):
        inside = False
        for j in range(size):
            if (i, j) in paths[0]:
                if grid[i][j][0] in "|JLS":
                    inside = not inside
                print(f'{Colors.BACK_WHITE}{Colors.RED}{readable[grid[i][j][0]]}{Colors.END}', end='')
            else:
                if inside:
                    count += 1
                    print(f'{Colors.BOLD}{Colors.BACK_GREEN}·{Colors.END}', end='')
                else:
                    print(f'{Colors.BACK_BLUE} {Colors.END}', end='')
        print()
    return count


def get_paths(start, grid):
    paths = [list((start, i)) for i in grid[start[0]][start[1]][1]]
    while True:
        has_next = False
        # print([len(i) for i in paths], sep='', end="\r", flush=True)
        for idx, path in enumerate(paths):
            prev, pos = path[-2:]
            for nxt in grid[pos[0]][pos[1]][1]:
                if nxt == prev:
                    continue  # not going backwards
                if nxt in path:
                    paths[idx].append(nxt)
                    continue  # loop detected
                has_next = True
                paths[idx].append(nxt)

        if not has_next:
            break

    return [i for i in paths if i[-1] == start]


def get_grid(filename):
    with (open(filename) as file):
        s = (0, 0)
        raw_file = file.readlines()
        size = len(raw_file)
        grid = [[[] for _ in range(size)] for _ in range(size)]
        for row, raw_line in enumerate(raw_file):
            for col, val in enumerate(raw_line.rstrip()):
                nxt = []
                for conn in connections[val]:
                    x, y = conn
                    _x = row + x
                    _y = col + y
                    if -1 in [_x, _y] or size in [_x, _y]:
                        continue  # out of range
                    nxt.append((_x, _y))

                grid[row][col] = (val, nxt)
                if val == 'S':
                    s = (row, col)

        return s, grid


assert 4 == part1("test/day10_1.txt")
assert 8 == part1("test/day10_2.txt")
st = time.time()
print("Day 10, Part 1:", part1("input/day10.txt"), " in %s seconds " % (time.time() - st))

st = time.time()
print("Day 10, Part 2:", part2("input/day10.txt"), " in %s seconds " % (time.time() - st))
