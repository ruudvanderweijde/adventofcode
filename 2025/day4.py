import time


DIRS = [[0,1],[0,-1],[1,1],[1,-1],[-1,1],[-1,-1],[1,0],[-1,0]]


def main(filename, max_iterations):
    grid = read_input(filename)

    return get_rolls(grid, set(), 0, max_iterations)


def get_rolls(grid: list[str], to_remove: set[tuple[int, int]], iteration: int, max_iteration: int) -> int:
    if iteration != 0 and len(to_remove) == 0:
        return 0
    if iteration == max_iteration:
        return 0

    # remove rolls
    for y, x in to_remove:
        grid[y] = grid[y][:x] + '.' + grid[y][x+1:]

    to_remove = set()
    height = len(grid)
    for y in range(height):
        width = len(grid[y])
        for x in range(width):
            v = grid[y][x]
            if v == '@':
                adj = 0
                for y_, x_ in DIRS:
                    nx, ny = x + x_, y + y_
                    if 0 <= nx < width and 0 <= ny < height and grid[ny][nx] == '@':
                        adj += 1
                if adj < 4:
                    to_remove.add((y,x))

    return len(to_remove) + get_rolls(grid, to_remove, iteration+1, max_iteration)


def read_input(filename):
    with open(filename) as file:
        return [i.rstrip() for i in file.readlines()]


start = time.time()
assert 13 == main("test/day4.txt", 1)
print("Day 4, Part 1:", main("input/day4.txt", 1))
print("Duration: ", time.time()-start)

start = time.time()
assert 43 == main("test/day4.txt", -1)
print("Day 4, Part 2:", main("input/day4.txt", -1))
print("Duration: ", time.time()-start)