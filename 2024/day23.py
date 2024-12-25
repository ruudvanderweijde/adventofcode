import time


def part1(filename):
    fromto = read_input(filename)
    connections = set()
    for k in fromto:
        for nk in fromto[k]:
            for nnk in fromto[nk]:
                if k in fromto[nnk] and 't' in [k[0], nk[0], nnk[0]]:
                    connections.add(tuple(sorted([k, nk, nnk])))
    return len(connections)


def get_network(fromto, start, matches, res):
    key = tuple(sorted(matches))
    if key in res: return res
    res.add(key)
    for n in fromto[start]:
        if n in matches: continue
        if not matches <= fromto[n]: continue
        res |= get_network(fromto, n, {*matches, n}, res)
    return res


def part2(filename):
    fromto = read_input(filename)
    connections = set()
    for k in fromto:
        connections |= get_network(fromto, k, {k}, set())
    return ",".join(max(connections, key=len))


def read_input(filename):
    with open(filename) as file:
        fromto = {}
        for line in file.readlines():
            l, r = line.rstrip('\n').split('-')
            if l not in fromto: fromto[l] = set()
            if r not in fromto: fromto[r] = set()
            fromto[l].add(r)
            fromto[r].add(l)
        return fromto


assert 7 == part1("test/day23.txt")
start = time.time()
print("Day 23, Part 1:", part1("input/day23.txt"))
print("Duration: ", time.time()-start)

assert 'co,de,ka,ta' == part2("test/day23.txt")
start = time.time()
print("Day 23, Part 2:", part2("input/day23.txt"))
print("Duration: ", time.time()-start)
