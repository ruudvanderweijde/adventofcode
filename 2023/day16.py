import time


up = 0
right = 1
down = 2
left = 3

dirs = [
    (-1, 0),  # up
    (0, 1),  # right
    (1, 0),  # down
    (0, -1),  # left
]


def part1(filename):
    return visit(get_grid(filename), (0, 0), right)


def part2(filename):
    grid = get_grid(filename)
    score = 0
    for i in range(len(grid)):
        score = max(score, visit(grid, (0, i), down))
        score = max(score, visit(grid, (len(grid), i), up))
        score = max(score, visit(grid, (i, 0), right))
        score = max(score, visit(grid, (i, len(grid)), left))
    return score


def visit(grid, start_pos, start_dir):
    queue = [(start_pos, start_dir, set())]
    visited = set()

    while len(queue) > 0:
        current_pos, current_dir, seen = queue.pop(0)
        if not is_in_grid(grid, current_pos):
            continue
        if (current_pos, current_dir) in seen:
            continue

        visited.add(current_pos)
        seen.add((current_pos, current_dir))

        current_item = grid[current_pos[0]][current_pos[1]]

        next_dirs = []
        if current_item == '.':
            next_dirs = [current_dir]
        elif current_item == '|':
            if current_dir in [left, right]:
                next_dirs = [up, down]
            else:
                next_dirs = [current_dir]
        elif current_item == '-':
            if current_dir in [up, down]:
                next_dirs = [left, right]
            else:
                next_dirs = [current_dir]
        elif current_item == '/':
            mapping = {up: right, right: up, down: left, left: down}
            next_dirs = [mapping[current_dir]]
        elif current_item == '\\':
            mapping = {up: left, right: down, down: right, left: up}
            next_dirs = [mapping[current_dir]]

        for next_dir in next_dirs:
            next_pos = (current_pos[0] + dirs[next_dir][0], current_pos[1] + dirs[next_dir][1])
            queue.append((next_pos, next_dir, seen))

    return len(visited)


def is_in_grid(grid, pos):
    row, col = pos

    min_row = min_col = 0
    max_row = len(grid) - 1
    max_col = len(grid[0]) - 1

    return not (row < min_row or row > max_row or col < min_col or col > max_col)


def get_grid(filename):
    with open(filename) as file:
        return [[j for j in i.rstrip()] for i in file.readlines()]


assert 46 == part1("test/day16.txt")
st = time.time()
print("Day 16, Part 1:", part1("input/day16.txt"), " in %s seconds " % (time.time() - st))

assert 51 == part2("test/day16.txt")
st = time.time()
print("Day 16, Part 2:", part2("input/day16.txt"), " in %s seconds " % (time.time() - st))
