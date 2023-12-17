import sys
import time
import heapq

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


def main(filename, part):
    min_move = 1 if part == 1 else 4
    max_move = 3 if part == 1 else 10
    return visit(get_grid(filename), min_move, max_move)


def visit(grid, min_move, max_move):
    queue = [(0, (0, 0), -10, -1)]
    max_row = len(grid) - 1
    max_col = len(grid[0]) - 1
    heat_map = {}

    while len(queue) > 0:
        heat_loss, current_pos, current_dir, dir_length = heapq.heappop(queue)

        key = (current_pos, current_dir, dir_length)
        if key in heat_map:
            assert heat_loss >= heat_map[key]
            continue
        heat_map[key] = heat_loss

        for next_dir in [up, right, down, left]:
            next_pos = (current_pos[0] + dirs[next_dir][0], current_pos[1] + dirs[next_dir][1])

            if next_pos[0] < 0 or next_pos[0] > max_row or next_pos[1] < 0 or next_pos[1] > max_col:  # out of grid?
                continue

            dir_diff = abs(next_dir - current_dir)
            if dir_diff == 2:  # opposite dir?
                continue

            next_dir_length = (1 if dir_diff != 0 else dir_length+1)
            if dir_diff == 0 and next_dir_length > max_move:  # no more than X in the same dir?
                continue

            if dir_diff == 1 and dir_length < min_move and dir_length != -1:  # has travelled min length?
                continue

            heat = int(grid[next_pos[0]][next_pos[1]])
            heapq.heappush(queue, (heat_loss + heat, next_pos, next_dir, next_dir_length))

    min_heat = sys.maxsize
    for (pos, _, dir_length), heat in heat_map.items():
        if pos == (max_row, max_col) and dir_length >= min_move:
            min_heat = min(min_heat, heat)

    return min_heat


def is_in_grid(grid, pos):
    row, col = pos

    min_row = min_col = 0
    max_row = len(grid) - 1
    max_col = len(grid[0]) - 1

    return not (row < min_row or row > max_row or col < min_col or col > max_col)


def get_grid(filename):
    with open(filename) as file:
        return [[j for j in i.rstrip()] for i in file.readlines()]


assert 102 == main("test/day17.txt", part=1)
st = time.time()
print("Day 17, Part 1:", main("input/day17.txt", part=1), " in %s seconds " % (time.time() - st))

assert 94 == main("test/day17.txt", part=2)
assert 71 == main("test/day17_2.txt", part=2)
st = time.time()
print("Day 17, Part 2:", main("input/day17.txt", part=2), " in %s seconds " % (time.time() - st))
