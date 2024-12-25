import time


def main(filename):
    locks, keys = read_input(filename)
    fitting = 0
    for l in locks:
        for k in keys:
            if all([sum(p)<=5 for p in list(zip(l,k))]):
                fitting += 1
    return fitting


def read_input(filename):
    with open(filename) as file:
        keys = []
        locks = []
        for block in file.read().split("\n\n"):
            lines = block.split('\n')
            if lines[0] == '.....':
                keys.append([r.count('#')-1 for r in list(zip(*lines))])
            else:
                locks.append([r.count('#')-1 for r in list(zip(*lines))])
        return locks, keys


assert 3 == main("test/day25.txt")
start = time.time()
print("Day 25, Part 1:", main("input/day25.txt"))
print("Duration: ", time.time()-start)
