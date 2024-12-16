import heapq
import time

bold = ['\033[1m', '\033[0m']
dirs = [
    (-1, 0),  # N
    (0, 1),   # E
    (1, 0),   # S
    (0, -1),  # W
]

def main(filename, part2, min_score):
    start, grid = read_input(filename)
    dir = 1  # starting East
    scores = {}
    score_map = {}
    q = [(0, start, dir, set())]
    heapq.heapify(q)
    while q:
        s,(r,c),d,t = heapq.heappop(q) # row, col, direction, score

        k = "_".join(map(str, [r,c,d]))
        if (r,c,d) in t: continue
        t_ = t.copy()


        # if (r,c,d) in t_:
        #     continue # we've hit a loop
        t_.add((r,c,d))

        if s > min_score: continue

        if k in score_map and score_map[k] <= s and not part2:
            continue # we already have a shorter path
        elif k in score_map and score_map[k] < s and part2:
            continue  # for part 2 we need to keep track of same length
        else:
            score_map[k] = s
        dr, dc = dirs[d]
        # 3 options: move forward, move left, move right
        char = grid[r+dr][c+dc]
        if char == "E":
            # if part2:
            t_.add((r + dr, c + dc, d))
            if not s in scores: scores[s] = set()
            scores[s].update(t_)
            # print('got to E', min_score, s)
            min_score = min(min_score, s)
        if char == ".":
            heapq.heappush(q, (s+1, (r+dr, c+dc), d, t_))

        for nd in [(d+1)%4, (d-1)%4]:
            ndr, ndc = dirs[nd]
            if grid[r+ndr][c+ndc] == '.' and not (r,c, nd) in t_:
                heapq.heappush(q, (s+1000, (r, c), nd, t_))

    # if part2: print_grids(grid, scores[min_score])
    return min_score + 1 if not part2 else len({(r,c) for r,c,d in scores[min_score]})

def print_grid(grid):
    print(*["".join(r) for r in grid], sep="\n")

def print_grids(grid, pos):
    pos = {(r,c) for r,c,d in pos}
    for r in range(len(grid)):
        for c in range(len(grid[0])):
            print('O' if (r,c) in pos else grid[r][c], end='')
        print()

    # print(*["".join(r) for r in grid], sep="\n")

def read_input(filename):
    with open(filename) as file:
        grid = [list(l.strip('\n')) for l in file.readlines()]
        for r in range(len(grid)):
            for c in range(len(grid[0])):
                if grid[r][c] == 'S':
                    start = (r,c)

        return start, grid


t1 = main("test/day16.txt", False, float('inf'))
assert 7036 == t1, t1
t2 = main("test/day16_2.txt", False, float('inf'))
assert 11048 == t2, t2

start = time.time()
part1 = main("input/day16.txt", False, float('inf'))
print("Day 16, Part 1:", part1)
print("Duration: ", time.time()-start)

start = time.time()
t1_2 = main("test/day16.txt", True, t1)
assert 45 == t1_2, t1_2
print("Duration: ", time.time()-start)
start = time.time()
t2_2 = main("test/day16_2.txt", True, t2)
assert 64 == t2_2, t2_2
print("Duration: ", time.time()-start)

start = time.time()
part2 = main("input/day16.txt", True, part1)
print("Day 16, Part 2:", part2)
print("Duration: ", time.time()-start)
