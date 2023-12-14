import time


def main(filename, part):
    grid = get_grid(filename)
    for r in grid:
        r.insert(0, '#')
        r.append('#')
    grid.insert(0, ['#'] * len(grid[0]))
    grid.append(['#'] * len(grid[0]))

    if part == 1:
        return get_score(tilt(rot_90(grid)))
    if part == 2:
        scores = []
        target = 1000000000
        count = 0
        while True:
            grid, score = cycle(grid)
            scores.append(score)
            has_loop, start, length = get_loop(scores)
            if has_loop:
                break
            count += 1

        return scores[start + ((target - start) % length) - 1]

    assert False


def cycle(grid):
    grid = tilt(rot_90(grid))
    grid = tilt(rot_90(grid))
    grid = tilt(rot_90(grid))
    grid = tilt(rot_90(grid))
    score = get_score(rot_90(grid))
    return grid, score


def get_loop(scores):
    if len(scores) < 10:
        return False, 0, 0
    else:
        for loop_size in range(5, len(scores)//3):
            for offset in range(len(scores)//3):
                loop1 = scores[offset:loop_size + offset]
                loop2 = scores[loop_size + offset:2 * loop_size + offset]
                loop3 = scores[2 * loop_size + offset:3 * loop_size + offset]
                if loop1 == loop2 and loop1 == loop3:
                    return True, offset, loop_size
    return False, 0, 0


def tilt(grid):
    for x, col in enumerate(grid):
        for y, val in enumerate(col):
            if val == '#':
                target = y
                for i in range(y - 1, -1, -1):
                    if grid[x][i] == '#':
                        break
                    if grid[x][i] == 'O':
                        if target - 1 != i:
                            grid[x][target - 1] = 'O'
                            grid[x][i] = '.'
                        target -= 1
    return grid


def get_score(grid):
    total = 0
    for x, col in enumerate(grid):
        for y, val in enumerate(col):
            if val == '#':
                score = y
                for i in range(y - 1, -1, -1):
                    if grid[x][i] == '#':
                        break
                    if grid[x][i] == 'O':
                        total += score - 1
                    score -= 1
    return total


def rot_90(l):
    return [list(reversed(x)) for x in zip(*l)]


def get_grid(filename):
    with open(filename) as file:
        return [[j for j in i.rstrip()] for i in file.readlines()]


assert 136 == main("test/day14.txt", part=1)
st = time.time()
print("Day 14, Part 1:", main("input/day14.txt", part=1), " in %s seconds " % (time.time() - st))

assert 64 == main("test/day14.txt", part=2)
st = time.time()
print("Day 14, Part 2:", main("input/day14.txt", part=2), " in %s seconds " % (time.time() - st))