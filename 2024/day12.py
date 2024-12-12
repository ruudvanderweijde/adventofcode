N=(-1, 0)
E=(0, 1)
S=(1, 0)
W=(0, -1)

dirs = [N,E,S,W]


def part1(filename):
    return sum([perimeter(i) for i in (get_groups(read_input(filename)))])


def get_groups(grid):
    height = len(grid)
    width = len(grid[0])
    groups = []
    visited = set()
    for y, ys in enumerate(grid):
        for x, v in enumerate(ys):
            queue = [(y, x)]
            pack = []
            while queue:
                cy, cx = queue.pop(0)
                if (cy, cx) in visited: continue
                pack.append((cy, cx))
                visited.add((cy, cx))
                for (dy, dx) in dirs:
                    ny, nx = cy + dy, cx + dx
                    if 0 <= ny < height and 0 <= nx < width and grid[ny][nx] == v:
                        queue.append((ny, nx))
            if pack:
                groups.append(pack)

    return groups


def perimeter(coords):
    perimeter = 0
    for (y,x) in coords:
        for (dy, dx) in dirs:
            if (y + dy, x + dx) not in coords:
                perimeter += 1

    return len(coords) * perimeter


def part2(filename):
    grid = read_input(filename)
    return sum([sides(grid, i) for i in (get_groups(grid))])


def sides(grid, coords):
    directions_map = {}
    for y, x in coords:
        for d in dirs:
            if not d in directions_map: directions_map[d] = set()
            dy, dx = d
            if (y + dy, x + dx) not in coords:
                # it's a corner piece
                if d in [N,S]:
                    directions_map[d].add((y,x))
                else:
                    directions_map[d].add((x,y))


    sides = 0
    for items in directions_map.values():
        rows = {}  # y -> [xs]
        for k,v in items:
            if k not in rows: rows[k] = []
            rows[k].append(v)

        for row in rows.values():
            row.sort()
            prev = -10
            for v in row:
                if v - prev != 1: sides += 1
                prev = v


    return len(coords) * sides


def read_input(filename):
    with open(filename) as file:
        return [[j for j in i.rstrip()] for i in file.readlines()]


test = part1("test/day12.txt")
assert 1930 == test, test
print("Day 12, Part 1:", part1("input/day12.txt"))

test2 = part2("test/day12.txt")
assert 1206 == test2, test2
print("Day 12, Part 2:", part2("input/day12.txt"))