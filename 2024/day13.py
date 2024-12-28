from re import findall
import time


def main(filename, offset=0):
    machines = read_input(filename)
    return sum(run(ax, ay, bx, by, offset + xmax, offset + ymax) for ax, ay, bx, by, xmax, ymax in machines)


def run(ax,ay,bx,by,xmax,ymax):
    xymax = max(xmax, ymax)

    line_a = ((0,0), (ax * xymax, ay * xymax))
    line_b = ((xmax,ymax), (xmax-(bx*xymax), ymax-(by*xymax)))
    i1, _ = line_intersection(line_a, line_b)
    a = i1/ax

    line_a = ((xmax,ymax), (xmax-(ax*xymax), ymax-(ay*xymax)))
    line_b = ((0,0), (bx*xymax, by*xymax))
    i2, _ = line_intersection(line_a, line_b)
    b = i2/bx

    return int(a*3+b) if a.is_integer() and b.is_integer() else 0


def line_intersection(line1, line2):
    xdiff = (line1[0][0] - line1[1][0], line2[0][0] - line2[1][0])
    ydiff = (line1[0][1] - line1[1][1], line2[0][1] - line2[1][1])

    def det(a, b):
        return a[0] * b[1] - a[1] * b[0]

    div = det(xdiff, ydiff)
    if div == 0:
        return False

    d = (det(*line1), det(*line2))
    x = det(d, xdiff) / div
    y = det(d, ydiff) / div

    return x, y


def read_input(filename):
    with open(filename) as file:
        return [list(map(int, findall(r'\d+', line.rstrip()))) for line in file.read().split("\n\n")]


t = main("test/day13.txt")
assert 480 == t, t
start = time.time()
print("Day 13, Part 1:", main("input/day13.txt"))
print("Duration: ", time.time()-start)

start = time.time()
print("Day 13, Part 2:", main("input/day13.txt", 10000000000000))
print("Duration: ", time.time()-start)
