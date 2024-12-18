import time
from collections import deque

dirs = [
    (-1, 0),  # N
    (0, 1),   # E
    (1, 0),   # S
    (0, -1),  # W
]

def main(filename, size, first, part):
    corrupt = read_input(filename)
    if part == 1:
        return path(size, corrupt[:first])

    for i in range(len(corrupt), first, -1):
        if path(size, corrupt[:i]) != 0:
            return "{},{}".format(*corrupt[i])


def path(size, corrupt):
    seen = {(0,0)}
    q = deque([(0, 0, 0)])
    while q:
        r,c,d = q.popleft()
        for dr, dc in dirs:
            nr, nc = r+dr, c+dc
            np = (nr, nc)
            if 0 <= nr <= size and 0 <= nc <= size and np not in corrupt and np not in seen:
                if np == (size,size):
                    return d+1

                seen.add(np)
                q.append((nr,nc,d+1))

    return 0


def read_input(filename):
    with open(filename) as file:
        return [tuple(map(int, (l.strip('\n').split(',')))) for l in file.readlines()]


part = 1
t = main("test/day18.txt", 6, 12, part)
assert 22 == t, t

start = time.time()
part1 = main("input/day18.txt", 70, 1024, part)
print("Day 18, Part 1:", part1)
print("Duration: ", time.time()-start)

part = 2
t = main("test/day18.txt", 6, 12, part)
assert "6,1" == t, t

start = time.time()
part1 = main("input/day18.txt", 70, 1024, part)
print("Day 18, Part 1:", part1)
print("Duration: ", time.time()-start)
