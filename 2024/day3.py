from re import findall


def part1(filename):
    inp = read_input(filename, "mul\((\d+),(\d+)\)")
    sums = [[int(l) * int(r) for l, r in pair] for pair in inp]
    return sum(sum(s) for s in sums)


def part2(filename):
    inp = read_input(filename, "mul\((\d+),(\d+)\)|(do\(\))|(don't\(\))")
    total = 0
    enabled = True
    for i in inp:
        for j in i:
            l, r, do, dont = j
            if do:
                enabled = True
                continue
            elif dont:
                enabled = False
            elif enabled:
                total += int(l) * int(r)
    return total


def read_input(filename, pattern):
    with open(filename) as file:
        return [findall(pattern, line.rstrip()) for line in file]


assert 161 == part1("test/day3.txt", )
print("Day 3, Part 1:", part1("input/day3.txt"))

assert 48 == part2("test/day3.txt")
print("Day 3, Part 2:", part2("input/day3.txt"))
