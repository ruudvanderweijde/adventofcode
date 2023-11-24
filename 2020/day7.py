import re


def part1(filename, target):
    bags = build_tree(filename)

    count = 0
    for key, value in bags.items():
        if key == target:
            continue

        todo = [key]
        while len(todo):
            item = todo.pop()
            if item == target:
                count += 1
                todo = []
            else:
                [todo.append(x[1]) for x in bags[item]]

    return count


def part2(filename, target):
    bags = build_tree(filename)

    return count_bags(bags, target) - 1


def count_bags(bags, bag_type):
    return 1 + sum(int(number) * count_bags(bags, colour) for number, colour in bags[bag_type])


def build_tree(filename):
    data = read_input(filename)
    tree = {}
    for d in data:
        parent = re.match(r'(\w+ \w+) bags contain', d)[1]
        children = re.findall(r'(\d+) (\w+ \w+)', d)
        tree[parent] = children

    return tree


def read_input(filename):
    with open(filename) as file:
        return [line.rstrip() for line in file]


target = 'shiny gold'
assert 4 == part1("test/day7.txt", target)
print("Day 7, Part 1:", part1("input/day7.txt", target))

# note: for part 2 I looked up answers. Todo: do it myself from scratch.
assert 32 == part2("test/day7.txt", target)
assert 126 == part2("test/day7.2.txt", target)
print("Day 7, Part 2:", part2("input/day7.txt", target))