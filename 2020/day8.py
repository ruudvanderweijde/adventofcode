import copy


def part1(filename):
    instructions = get_instructions(filename)
    _, accumulator = run(instructions)
    return accumulator


def part2(filename):
    instructions = get_instructions(filename)
    for index, _ in enumerate(instructions):
        _instructions = copy.deepcopy(instructions)
        op = _instructions[index][0]
        if op == "acc":
            continue
        if op == "nop":
            _instructions[index][0] = "jmp"
        if op == "jmp":
            _instructions[index][0] = "nop"

        print(_instructions)
        has_loop, accumulator = run(_instructions)
        if not has_loop:
            return accumulator

    raise Exception("not expected")


def run(instructions):
    index = 0
    accumulator = 0
    visited = []
    has_loop = False

    while True:
        op, num = instructions[index]
        if op == 'nop':
            index += 1
        if op == 'acc':
            index += 1
            accumulator += int(num)
        if op == 'jmp':
            index += int(num)
        if index in visited:
            has_loop = True
            break
        else:
            visited.append(index)
        if index >= len(instructions):
            break

    return has_loop, accumulator


def get_instructions(filename):
    with open(filename) as file:
        return [line.rstrip().split() for line in file]


assert 5 == part1("test/day8.txt")
print("Day 8, Part 1:", part1("input/day8.txt"))

assert 8 == part2("test/day8.txt")
print("Day 8, Part 2:", part2("input/day8.txt"))