from time import time
from collections import OrderedDict


def main(filename, part2=False):
    line = read_input(filename)
    free = False
    items = []
    iter = 0
    all_free = OrderedDict()
    for val in line:
        if free:
            all_free[len(items)] = val
            items.extend([-1]*val)
        else:
            items.extend([iter]*val)
            iter += 1
        free = not free

    if not part2:
        for _ in range(items.count(-1)):
            first_free = items.index(-1)
            if first_free == -1:
                break
            items[first_free] = items.pop()
    else:
        max = items[-1]
        if max == -1:
            raise Exception("Not expected free at the end")
        for i in range(max,0,-1):
            indices = [j for j, x in enumerate(items) if x == i]
            for k, v in all_free.items():
                if k > indices[0]:
                    # do not move things to the right
                    break
                if v >= len(indices):
                    # we can move!
                    for ind in indices:
                        items[ind] = -1
                    for ind in range(k, k+len(indices)):
                        items[ind] = i

                    del all_free[k]
                    free_left = v - len(indices)
                    if free_left > 0:
                        all_free[k+len(indices)] = free_left

                    all_free = OrderedDict(sorted(all_free.items()))
                    break

    score = 0
    for k, v in enumerate(items):
        if v == -1: v = 0
        score += k*v

    return score


def read_input(filename):
    with open(filename) as file:
        return [int(i) for i in list(file.readlines()[0])]


start = time()
assert 1928 == main("test/day9.txt")
print("Day9, Part 1:", main("input/day9.txt"))
print("Duration: ", time()-start)

start = time()
test = main("test/day9.txt", True)
assert 2858 == test, test
print("Day9, Part 2:", main("input/day9.txt", True))
print("Duration: ", time()-start)