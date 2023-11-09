from re import split


def part1(filename):
    return len([item for item in read_input(filename) if matchPart1(item)])


def part2(filename):
    return len([item for item in read_input(filename) if matchPart2(item)])


def read_input(filename):
    with open(filename) as file:
        return [split(r'[-: ]+', line.rstrip()) for line in file]


def matchPart1(item):
    start, end, pattern, password = item
    return int(start) <= password.count(pattern) <= int(end)


def matchPart2(item):
    start, end, pattern, password = item
    return (password[int(start)-1] == pattern) ^ (password[int(end)-1] == pattern)


assert 2 == part1("test/day2.txt")
print("Day 2, Part 1:", part1("input/day2.txt"))

assert 1 == part2("test/day2.txt")
print("Day 2, Part 2:", part2("input/day2.txt"))
