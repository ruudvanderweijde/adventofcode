import time

dirs = {
    0: (-1, 0),  # N
    1: (0, 1),   # E
    2: (1, 0),   # S
    3: (0, -1),  # W
}


def part1(filename):
    grid = read_input(filename)
    visited, _ = visit(grid, 0, find_start_pos(grid))
    return len(visited)


def part2(filename):
    grid = read_input(filename)
    pos = find_start_pos(grid)
    visited, _ = visit(grid, 0, pos)
    count = 0
    for v in visited:
        if v == pos: continue # skip the start pos
        grid2 = grid[:]
        row = grid2[v[0]]
        grid2[v[0]] = row[:v[1]] + '#' + row[v[1] + 1:]

        _, has_loop = visit(grid2, 0, pos)
        if has_loop:
            count += 1

    return count


def find_start_pos(grid):
    pos = (-1, -1)
    for y, line in enumerate(grid):
        x = line.find('^')
        if x >= 0:
            pos = (y, x)
            break
    return pos


def visit(grid, dir, pos):
    maxy = len(grid)
    maxx = len(grid[0])
    visited = set()
    loopdetection = set()
    while True:
        if (pos, dir) in loopdetection:
            return visited, True
        loopdetection.add((pos, dir))

        visited.add(pos)
        y, x = pos
        y_, x_ = dirs[dir]
        ny, nx = y + y_, x + x_

        if not (0 <= ny < maxy and 0 <= nx < maxx):
            break

        if grid[ny][nx] == "#":
            dir = (dir + 1) % 4
        else:
            pos = (ny, nx)

    return visited, False


def read_input(filename):
    with open(filename) as file:
        return [i.rstrip() for i in file.readlines()]


assert 41 == part1("test/day6.txt")
print("Day6, Part 1:", part1("input/day6.txt"))

start = time.time()
assert 6 == part2("test/day6.txt")
print("Day6, Part 2:", part2("input/day6.txt"))
print("Duration: ", time.time()-start)
