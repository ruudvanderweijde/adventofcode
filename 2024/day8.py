import time


def main(filename, loop=False):
    all, dict, (maxY, maxX) = read_input(filename)
    nodes = set()
    for k in dict:
        locations = dict[k]
        for i in range(len(locations)):
            ly, lx = locations[i]
            for j in range(i + 1, len(locations)):
                ry, rx = locations[j]
                if loop:
                    nodes.add((ly, lx))
                    nodes.add((ry, rx))

                added = True
                size = 1
                while added:
                    added = False
                    a1x, a1y, a2x, a2y = getNext(lx, ly, rx, ry, size)
                    if 0 <= a1y <= maxY and 0 <= a1x <= maxX:
                        nodes.add((a1y, a1x))
                        added = True
                    if 0 <= a2y <= maxY and 0 <= a2x <= maxX:
                        nodes.add((a2y, a2x))
                        added = True
                    size += 1
                    if not loop: break
    return len(nodes)


def getNext(lx, ly, rx, ry, x):
    nw = (min(ly, ry), min(lx, rx))
    ne = (min(ly, ry), max(lx, rx))
    sw = (max(ly, ry), min(lx, rx))
    se = (max(ly, ry), max(lx, rx))

    if nw in [(ly, lx), (ry, rx)]:
        a1y, a1x = (nw[0] - (sw[0] - nw[0])*x), (nw[1] - (ne[1] - nw[1])*x)
        a2y, a2x = (se[0] + (sw[0] - nw[0])*x), (se[1] + (se[1] - sw[1])*x)
    else:
        a1y, a1x = (ne[0] - (se[0] - ne[0])*x), (ne[1] + (ne[1] - nw[1])*x)
        a2y, a2x = (sw[0] + (sw[0] - nw[0])*x), (sw[1] - (se[1] - sw[1])*x)
    return a1x, a1y, a2x, a2y


def print_grid(dict, nodes, maxY, maxX):
    map = {}
    for key, value in dict.items():
        for pos in value:
            map[pos] = key

    print(map)
    for y in range(maxY + 1):
        for x in range(maxX + 1):
            pos = (y, x)
            if pos in map:
                print(map[pos], end='')
            elif pos in nodes:
                print('#', end='')
            else:
                print('.', end='')
        print('')


def find_start_pos(grid):
    pos = (-1, -1)
    for y, line in enumerate(grid):
        x = line.find('^')
        if x >= 0:
            pos = (y, x)
            break
    return pos


def read_input(filename):
    with open(filename) as file:
        dict_ = {}
        all_ = []
        size = (0,0)
        for y, xs in enumerate(file.readlines()):
            for x, v in enumerate(xs.rstrip()):
                size = (y,x)
                if v == '.': continue
                if not v in dict_: dict_[v] = []
                dict_[v].append((y, x))
                all_.append((y, x))
        return all_, dict_, size


assert 14 == main("test/day8.txt")
print("Day8, Part 1:", main("input/day8.txt"))

start = time.time()
test = main("test/day8.txt", True)
assert 34 == test, test
print("Day8, Part 2:", main("input/day8.txt", True))
print("Duration: ", time.time()-start)
