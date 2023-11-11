def part1(filename):
    with open(filename) as file:
        return sum([len(set(line.replace("\n", ''))) for line in file.read().split("\n\n")])


def part2(filename):
    with open(filename) as file:
        groups = [list(line.split("\n")) for line in file.read().split("\n\n")]
        common_chars = [set.intersection(*map(set, i)) for i in groups]
        return sum([len(i) for i in common_chars])


assert 11 == part1("test/day6.txt")
print("Day 6, Part 1:", part1("input/day6.txt"))

assert 6 == part2("test/day6.txt")
print("Day 6, Part 2:", part2("input/day6.txt"))