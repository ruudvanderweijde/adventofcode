import time


def main(filename, part=1):
    return sum([get_next(i, part) for i in read_input(filename)])


def get_next(numbers, part):
    diffs = [numbers]
    depth = 0
    while True:
        next_diff = []
        all_zero = True
        for k in range(len(diffs[depth])-1):
            diff = diffs[depth][k + 1] - diffs[depth][k]
            next_diff.append(diff)
            if diff != 0:
                all_zero = False
        diffs.append(next_diff)
        depth += 1
        if all_zero:
            break

    if part == 1:
        for i in range(depth, 0, -1):
            res = diffs[i][-1] + diffs[i-1][-1]
            diffs[i-1].append(res)

        return diffs[0][-1]

    if part == 2:
        for i in range(depth, 0, -1):
            res = diffs[i-1][0] - diffs[i][0]
            diffs[i-1].insert(0, res)

        return diffs[0][0]


def read_input(filename):
    with open(filename) as file:
        return [[int(i) for i in j.split()] for j in file.readlines()]


assert 114 == main("test/day9.txt")
st = time.time()
print("Day 9, Part 1:", main("input/day9.txt"), " in %s seconds " % (time.time() - st))

assert 2 == main("test/day9.txt", part=2)
st = time.time()
print("Day 9, Part 2:", main("input/day9.txt", part=2), "in %s seconds " % (time.time() - st))
