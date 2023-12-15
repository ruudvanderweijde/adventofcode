import time


def part1(filename):
    line = readfile(filename)
    return sum([score(i) for i in line.split(',')])


def part2(filename):
    line = readfile(filename)
    boxes = dict([(i, []) for i in range(256)])

    for i in line.split(','):
        if '=' in i:
            k, r = i.split('=')
            s = score(k)
            has_item = False
            for _k, _v in enumerate(boxes[s]):
                x, y = _v
                if x == k:
                    has_item = True
                    boxes[s][_k] = (k, int(r))
                    break

            if not has_item:
                boxes[s].append((k, int(r)))
        elif '-' in i:
            k = i[:-1]
            s = score(k)
            for _k, _v in enumerate(boxes[s]):
                x, y = _v
                if x == k:
                    del boxes[s][_k]
        else:
            assert False

    total = 0
    for key, values in boxes.items():
        for index, value in enumerate(values):
            s = (key + 1) * (index + 1) * value[1]
            total += s

    return total


def score(hash):
    s = 0
    for c in hash:
        s += ord(c)
        s *= 17
        s %= 256
    return s


def readfile(filename):
    with open(filename) as file:
        return file.read().strip()


assert 52 == score("HASH")
assert 1320 == part1("test/day15.txt")
st = time.time()
print("Day 15, Part 1:", part1("input/day15.txt"), " in %s seconds " % (time.time() - st))

assert 145 == part2("test/day15.txt")
st = time.time()
print("Day 15, Part 2:", part2("input/day15.txt"), " in %s seconds " % (time.time() - st))