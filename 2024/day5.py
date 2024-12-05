import time


def main(filename):
    order_rules, inputs = read_input(filename)
    valid_sum = 0
    invalid_sum = 0

    for iteration, lines in enumerate(inputs):
        valid = is_valid(lines, order_rules)
        if valid:
            valid_sum += lines[len(lines)//2]
        else:
            sorted_lines = sort_list(lines, order_rules)
            assert is_valid(sorted_lines, order_rules), "Sorted list is not valid!"
            invalid_sum += sorted_lines[len(sorted_lines)//2]

    return valid_sum, invalid_sum


def is_valid(row, order_rules):
    for i in range(0, len(row)):
        for before in row[:i]:
            if [before, row[i]] not in order_rules:
                return False
        for after in row[i + 1:]:
            if [row[i], after] not in order_rules:
                return False

    return True


def sort_list(row, order_rules):
    new = [row[0]]
    for i in row[1:]:
        for pos in range(len(new)+1):
            tryout = new[:]
            tryout.insert(pos, i)
            valid = is_valid(tryout, order_rules)
            if valid:
                new = tryout
                break
    return new


def read_input(filename):
    with open(filename) as file:
        order_rules, inputs = file.read().split("\n\n")
        return [list(map(int, r.split('|'))) for r in order_rules.splitlines()], [list(map(int, i.split(','))) for i in inputs.splitlines()]


assert (143, 123) == main("test/day5.txt")
start = time.time()
print("Day 5, Part 1&2:", main("input/day5.txt"))
print("Duration: ", time.time()-start)
