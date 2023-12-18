# credits to https://www.youtube.com/watch?v=bGWK76_e-LM for the solution of part 2
import time

dirs = {
    'U': (-1, 0),  # up
    'R': (0, 1),  # right
    'D': (1, 0),  # down
    'L': (0, -1),  # left
}


def main(filename, part):
    r, c = (0, 0)
    visited = [(r, c)]
    visited_points = 0
    for d, i, color in get_input(filename):
        d = d if part == 1 else {'0': 'R', '1': 'D', '2': 'L', '3': 'U', }[color[-1]]
        length = int(i) if part == 1 else (int(color[:5], 16))
        r_, c_ = dirs[d]
        visited_points += length
        r = r + (length * r_)
        c = c + (length * c_)
        visited.append((r, c))

    inner_area = area_by_shoelace(*zip(*visited))
    border_area = inner_area - visited_points // 2 + 1

    return border_area + visited_points


def get_input(filename):
    with open(filename) as file:
        return [i.replace('(#', '').strip(')\n').split(' ') for i in file.readlines()]


def area_by_shoelace(x, y):
    return abs(sum(x[i - 1] * y[i] - x[i] * y[i - 1] for i in range(len(x)))) // 2


# Didn't work for part2 :(
def count_inside(coordinates):
    visited = {}
    min_pos = min(sorted(coordinates, key=lambda x: min(x[0], x[1]))[0]) - 2
    max_pos = max(sorted(coordinates, key=lambda x: max(x[0], x[1]), reverse=True)[0]) + 2

    queue = [(min_pos, min_pos)]
    while len(queue) > 0:
        cord = queue.pop(0)
        if cord in visited:
            continue
        visited[cord] = cord in coordinates

        for r_, c_ in [[0, 1], [0, -1], [1, 0], [-1, 0]]:
            next_r = cord[0] + r_
            next_c = cord[1] + c_
            if min_pos <= next_r <= max_pos and min_pos <= next_c <= max_pos:
                if (next_r, next_c) in coordinates:
                    continue
                queue.append((next_r, next_c))

    # for i in range(min_pos, max_pos):
    #     for j in range(min_pos, max_pos):
    #         if (i,j) in coordinates:
    #             print('#', end='')
    #         elif (i, j) in visited:
    #             print('.', end='')
    #         else:
    #             print(' ', end='')
    #     print()

    return ((max_pos + 1 - min_pos) * (max_pos + 1 - min_pos)) - len(visited)


assert 62 == main("test/day18.txt", part=1)
st = time.time()
print("Day 18, Part 1:", main("input/day18.txt", part=1), " in %s seconds " % (time.time() - st))

assert 952408144115 == main("test/day18.txt", part=2)
st = time.time()
print("Day 18, Part 2:", main("input/day18.txt", part=2), " in %s seconds " % (time.time() - st))
