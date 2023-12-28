# part 2 taken from: https://www.youtube.com/watch?v=9UOMZSL0JTg
import time
from collections import deque


def part1(filename, steps):
    grid, start, _ = get_grid(filename)

    answer = my_fill(grid, start, steps)
    assert answer == fill(grid, start, steps)

    return answer


def my_fill(grid, start, steps):
    moves = set()
    visited = set()
    queue = [(start, 0)]
    while len(queue) > 0:
        pos, dist = queue.pop(0)
        if (pos, dist) in visited:
            continue
        visited.add((pos, dist))
        if dist == steps:
            moves.add(pos)
            continue

        r, c = pos
        for r_, c_ in [(-1, 0), (0, 1), (1, 0), (0, -1)]:
            (nr, nc) = (r+r_, c+c_)
            if (nr, nc) in grid:
                queue.append(((nr, nc), dist + 1))

    return len(moves)


def fill(grid, start, steps):
    ans = set()
    seen = {start}
    q = deque([(start, steps)])

    while q:
        pos, s = q.popleft()

        if s % 2 == 0:
            ans.add(pos)
        if s == 0:
            continue

        r, c = pos
        for next_pos in [(r + 1, c), (r - 1, c), (r, c + 1), (r, c - 1)]:
            if next_pos in grid and next_pos not in seen:
                seen.add(next_pos)
                q.append((next_pos, s - 1))

    return len(ans)


def part2(filename, steps):
    grid, start, size = get_grid(filename)
    mid = start[0]

    assert steps % size == size // 2, 'failed to assert that we can move till the end, fails for the test data'

    # max distance will look something like this:
    #      #
    #    # # #
    #  # # # # #
    #    # # #
    #      #
    grid_width = steps // size - 1

    # // 2 * 2 means rounding it down to the nearest two
    number_of_odd_grids  = (grid_width // 2 * 2 + 1) ** 2
    number_of_even_grids = ((grid_width + 1) // 2 * 2) ** 2

    number_of_odd_points  = fill(grid, start, size * 2 + 1)
    number_of_even_points = fill(grid, start, size * 2)

    corner_top    = fill(grid, (size - 1, mid), size - 1)
    corner_right  = fill(grid, (size // 2, 0),  size - 1)
    corner_bottom = fill(grid, (0, mid),        size - 1)
    corner_left   = fill(grid, (mid, size - 1), size - 1)

    small_top_right    = fill(grid, (size - 1, 0),        size // 2 - 1)
    small_top_left     = fill(grid, (size - 1, size - 1), size // 2 - 1)
    small_bottom_right = fill(grid, (0, 0),               size // 2 - 1)
    small_bottom_left  = fill(grid, (0, size - 1),        size // 2 - 1)

    large_top_right    = fill(grid, (size - 1, 0),        size * 3 // 2 - 1)
    large_top_left     = fill(grid, (size - 1, size - 1), size * 3 // 2 - 1)
    large_bottom_right = fill(grid, (0, 0),               size * 3 // 2 - 1)
    large_bottom_left  = fill(grid, (0, size - 1),        size * 3 // 2 - 1)

    return (
        number_of_odd_grids  * number_of_odd_points +
        number_of_even_grids * number_of_even_points +
        corner_top + corner_right + corner_bottom + corner_left +
        (grid_width + 1) * (small_top_right + small_top_left + small_bottom_right + small_bottom_left) +
        grid_width * (large_top_right + large_top_left + large_bottom_right + large_bottom_left)
    )


def get_grid(filename):
    with open(filename) as file:
        max_r = 0
        max_c = 0

        grid = set()
        start = (0, 0)
        for r, cs in enumerate(file.readlines()):
            max_r = max(max_r, r)
            for c, val in enumerate(cs.rstrip()):
                max_c = max(max_c, c)
                pos = (r, c)
                if val == 'S':
                    val = '.'
                    start = pos
                if val == '.':
                    grid.add(pos)

        assert max_r == max_c, 'failed to assert that the grid is a square'
        assert start[0] == start[1] == max_r // 2, 'failed to assert that the start pos is in the middle'

        return grid, start, max_r + 1


assert 16 == part1("test/day21.txt", 6)
st = time.time()
print("Day 21, Part 1:", part1("input/day21.txt", 64), " in %s seconds " % (time.time() - st))

# for steps, reach in [
#     (6, 16),
#     (10, 50),
#     (50, 1594),
#     (100, 6536),
#     (500, 167004),
#     (1000, 668697),
#     (5000, 16733044),
# ]:
#     actual = part2("test/day21.txt", steps)
#     print(actual)
#     assert reach == actual, str(actual) + '=actual || reach=' + str(reach)

st = time.time()
print("Day 21, Part 2:", part2("input/day21.txt", 26501365), " in %s seconds " % (time.time() - st))
