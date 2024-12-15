from re import findall
from collections import deque
from math import inf
import time

bold = ['\033[1m', '\033[0m']
dirs = [
    (-1, 0),  # up
    (0, 1),  # right
    (1, 0),  # down
    (0, -1),  # left
]

def part1(filename, width, height, runs):
    robots = read_input(filename)

    xmid = width // 2
    ymid = height // 2
    lt, rt, lb, rb = 0, 0, 0, 0
    for x, y, x_, y_ in robots:
        x__ = (x + runs * x_) % width
        y__ = (y + runs * y_) % height
        if x__ > xmid:
            if y__ > ymid:
                rb += 1
            elif y__ < ymid:
                lb += 1
        elif x__ < xmid:
            if y__ > ymid:
                rt += 1
            elif y__ < ymid:
                lt += 1

    return lt * rt * lb * rb


def part2(filename, width, height):
    robots = read_input(filename)
    runs = 1
    while True:
        runs += 1
        positions = []
        for x, y, x_, y_ in robots:
            x__ = (x + runs * x_) % width
            y__ = (y + runs * y_) % height
            positions.append((x__, y__))
        print(runs, end='\r')
        if find_tree(positions):
            print_robots(positions, height, width)
            break

    return runs


def print_robots(positions, height, width):
    for y in range(height+1):
        for x in range(width+ 1):
            if (x,y) in positions:
                print(positions.count((x,y)), end='')
            else:
                print('.', end='')
        print()


def read_input(filename):
    with open(filename) as file:
        return [list(map(int, findall(r'-?\d+', line.rstrip()))) for line in file.readlines()]


def find_tree(positions):
    for x,y in positions:
        filled = flood_fill(positions, x, y)
        if len(filled) > 20:
            print()
            print_robots(filled, 101,103)
            print()
            return True
    return False


def flood_fill(positions, x, y):
    q = deque([(x,y)])
    visited = set()
    while q:
        x_, y_ = q.popleft()
        if (x_, y_) in visited: continue
        visited.add((x_, y_))

        for dx, dy in dirs:
            nx, ny = dx+x_, dy+y_
            if (nx, ny) in positions:
                q.append((nx, ny))

    return list(visited)

assert 12 == part1("test/day14.txt", 11, 7, 100)
print("Day 14, Part 1:", part1("input/day14.txt", 101, 103, 100))

start = time.time()
print("Day 14, Part 2:", part2("input/day14.txt", 101, 103))
print("Duration: ", time.time()-start)
