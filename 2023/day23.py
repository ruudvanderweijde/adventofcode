# solution inspired by: https://github.com/hyper-neutrino/advent-of-code/blob/main/2023/day23p2.py
from time import time

part1 = {
    '^': [(-1, 0)],
    '>': [(0, 1)],
    'v': [(1, 0)],
    '<': [(0, -1)],
    '.': [(-1, 0), (0, 1), (1, 0), (0, -1)],
}

part2 = {
    '^': [(-1, 0), (0, 1), (1, 0), (0, -1)],
    '>': [(-1, 0), (0, 1), (1, 0), (0, -1)],
    'v': [(-1, 0), (0, 1), (1, 0), (0, -1)],
    '<': [(-1, 0), (0, 1), (1, 0), (0, -1)],
    '.': [(-1, 0), (0, 1), (1, 0), (0, -1)],
}


def main(filename, dirs):
    dag, start, end = get_dag(filename, dirs)

    return dfs(dag, start, end)


def print_dag(dag):
    print('digraph mygraph {')
    for src, destinations in dag.items():
        for dest, dist in destinations.items():
            print(f'"{src}" -> "{dest}" [label = "{dist}"]')
    print('}')


def dfs(graph, start, end, visited=None):
    if start == end:
        return 0

    max_dist = -float("inf")

    if visited is None:
        visited = set()
    visited.add(start)

    for nxt in graph[start]:
        if nxt not in visited:
            max_dist = max(max_dist, dfs(graph, nxt, end, visited) + graph[start][nxt])
    visited.remove(start)

    return max_dist


def get_dag(filename, dirs):
    with open(filename) as file:
        readlines = file.readlines()
        grid = dict()
        for x, ys in enumerate(readlines):
            for y, val in enumerate(ys.strip()):
                if val == '#':
                    continue
                grid[(x, y)] = val

        start = min(grid.keys(), key=lambda t: t[0])
        end = max(grid.keys(), key=lambda t: t[0])

        forks = {start, end}
        for pos in grid.keys():
            r, c = pos
            if len([(r_, c_) for (r_, c_) in dirs[grid[pos]] if (r + r_, c + c_) in grid]) > 2:
                forks.add(pos)

        dag = {f: {} for f in forks}
        for fork in forks:
            queue = [(fork, 0)]
            seen = {fork}

            while len(queue) > 0:
                pos, dist = queue.pop()

                if dist != 0 and pos in forks:
                    dag[fork][pos] = dist
                    continue

                r, c = pos
                for (r_, c_) in dirs[grid[pos]]:
                    next_pos = (r + r_, c + c_)
                    if next_pos not in seen and next_pos in grid:
                        queue.append((next_pos, dist + 1))
                        seen.add(next_pos)

        return dag, start, end


assert 94 == main("test/day23.txt", part1)
st = time()
print("Day 23, Part 1:", main("input/day23.txt", part1), "in %s seconds " % (time() - st))

assert 154 == main("test/day23.txt", part2)
st = time()
print("Day 23, Part 2:", main("input/day23.txt", part2), "in %s seconds " % (time() - st))
