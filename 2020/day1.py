from functools import reduce
from itertools import combinations


def main(filename, target=2020, size=2):
    combinations_list = list(combinations(read_input(filename), size))
    filtered_list = [combo for combo in combinations_list if sum(combo) == target]
    assert len(filtered_list) == 1, "Expected 1 value"
    return reduce(lambda x, y: x * y, filtered_list[0])


def read_input(filename):
    with open(filename) as file:
        return [int(line.rstrip()) for line in file]


assert 514579 == main("test/day1.txt")
print("Day 1, Part 1:", main("input/day1.txt"))

assert 241861950 == main(filename="test/day1.txt", size=3)
print("Day 1, Part 2:", main(filename="input/day1.txt", size=3))
