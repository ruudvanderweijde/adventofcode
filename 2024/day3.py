from re import findall


def main(filename, pattern):
    inp = read_input(filename, pattern)
    total = 0
    enabled = True
    for i in inp:
        for j in i:
            l, r, do, dont = j
            if do:
                enabled = True
            elif dont:
                enabled = False
            elif enabled:
                total += int(l) * int(r)
    return total


def read_input(filename, pattern):
    with open(filename) as file:
        return [findall(pattern, line.rstrip()) for line in file]


p1 = r'mul\((\d+),(\d+)\)|(do\(\))|(dummytext)'
p2 = r'mul\((\d+),(\d+)\)|(do\(\))|(don\'t\(\))'

assert 161 == main("test/day3.txt", p1)
print("Day 3, Part 1:", main("input/day3.txt", p1))

assert 48 == main("test/day3.txt", p2)
print("Day 3, Part 2:", main("input/day3.txt", p2))
