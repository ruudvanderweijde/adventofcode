def main(filename, part):
    input = read_input(filename)

    l = sorted(list(zip(*input))[0])
    r = sorted(list(zip(*input))[1])

    dist = 0
    for k,v in enumerate(l):
        if part == 1:
            dist += abs(l[k]-r[k])
        elif part == 2:
            dist += v * r.count(v)
    return dist

def read_input(filename):
    with open(filename) as file:
        return [(int (j[0]), int(j[1])) for j in [i.replace('   ', ' ').split(' ') for i in [line.rstrip() for line in file]]]


assert 11 == main("test/day1.txt", 1)
print("Day 1, Part 1:", main("input/day1.txt", 1))

assert 31 == main("test/day1.txt", 2)
print("Day 1, Part 2:", main("input/day1.txt", 2))
