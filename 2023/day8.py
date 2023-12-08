import time
import math


def part1(filename):
    return route('AAA', 'ZZZ', *read_input(filename))


def route(pointer, end, instructions, network):
    count = 0
    while pointer[-1*len(end):] != end[-1*len(end):]:
        if instructions[count % len(instructions)] == 'L':
            pointer = network[pointer][0]
        else:
            pointer = network[pointer][1]
        count += 1
    return count


def part2(filename):
    instructions, network = read_input(filename)
    res = [route(i, 'Z', instructions, network) for i in network.keys() if i[-1] == 'A']
    return math.lcm(*res)


def read_input(filename):
    with open(filename) as file:
        instructions, raw_network = file.read().split('\n\n')
        network = {}
        for i in raw_network.split('\n'):
            network[i[0:3]] = (i[7:10], i[12:15])
        return instructions, network


assert 2 == part1("test/day8_1.txt")
assert 6 == part1("test/day8_2.txt")
st = time.time()
print("Day 8, Part 1:", part1("input/day8.txt"), " in %s seconds " % (time.time() - st))

assert 6 == part2("test/day8_3.txt")
# st = time.time()
print("Day 8, Part 2:", part2("input/day8.txt"), "in %s seconds " % (time.time() - st))