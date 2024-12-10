import time

dirs = [
    (-1, 0),  # up
    (0, 1),  # right
    (1, 0),  # down
    (0, -1),  # left
]

def main(filename):
    grid, starts = read_input(filename)
    score1, score2 = 0, 0
    for start in starts:
        s1, s2 = find_paths(start, grid)
        score1 += s1
        score2 += s2
    return score1, score2


def find_paths(start, grid):
    max_y = len(grid)-1
    max_x = len(grid[0])-1

    queue = [(start, 0, [])]
    score = 0
    tops = set()
    paths = set()
    while len(queue) > 0:
        (y, x), inc, visits = queue.pop(0)
        if (y,x) in visits: continue
        v_ = visits.copy()
        v_.append((y,x))
        if inc == 9:
            score += 1
            tops.add((y,x))
            paths.add('__'.join([str(l) + '_' +str(r) for (l,r) in v_]))
        for dy, dx in dirs:
            y_, x_ = y+dy, x+dx
            if 0 <= y_ <= max_y and 0 <= x_ <= max_x:
                inc_ = grid[y_][x_]
                if inc_ == inc + 1:
                    queue.append(((y_,x_), inc_, v_))
    return len(tops), len(paths)


def read_input(filename):
    with open(filename) as file:
        grid = []
        starts = set()
        for y, xs in enumerate(file.readlines()):
            xs_rstrip = xs.rstrip()
            tmp = []
            for x, v in enumerate(xs_rstrip):
                if v == '.': v = 99
                if v == '0':
                    starts.add((y, x))
                tmp.append(int(v))
            grid.append(tmp)

        return grid, starts


test1, test2 = main("test/day10.txt")
assert 36 == test1, test1
assert 81 == test2, test2

start = time.time()
part1, part2 = main("input/day10.txt")
print("Day10, Part 1:", part1)
print("Day10, Part 2:", part2)
print("Duration: ", time.time()-start)