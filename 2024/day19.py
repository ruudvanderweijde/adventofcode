import time
from functools import lru_cache


def main(filename, part2=False):
    patterns, designs = read_input(filename)
    if part2:
        return sum([has_match(d, patterns) for d in designs])
    else:
        return sum([1 if has_match(d, patterns) else 0 for d in designs])


@lru_cache
def has_match(design, patterns):
    matches = 0
    if design == "":
        return 1
    for p in patterns.split(', '):
        if design.startswith(p):
            matches += has_match(design[len(p):], patterns)
    return matches


def read_input(filename):
    with open(filename) as file:
        patterns, designs = file.read().split('\n\n')
        return patterns, designs.split('\n')


t = main("test/day19.txt")
assert 6 == t, t
start = time.time()
print("Day 19, Part 1:", main("input/day19.txt"))
print("Duration: ", time.time()-start)

t = main("test/day19.txt", True)
assert 16 == t, t
start = time.time()
print("Day 19, Part 2:", main("input/day19.txt", True))
print("Duration: ", time.time()-start)