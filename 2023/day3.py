import math


def main(filename, part):
    # check prev, next char
    lines = read_input(filename)
    numbers = [ [] for _ in range(len(lines)) ]
    for row, line in enumerate(lines):
        num = ""
        for col, char in enumerate(line):
            if char.isdigit():
                num += char
                if col == len(line)-1:
                    numbers[row].append((int(num), col - len(num)+1, col))
                continue

            if num != "":
                numbers[row].append((int(num), col-len(num), col-1))
            num = ""

    gears = []
    valid_numbers = []
    for row, values in enumerate(numbers):
        for value in values:
            val, left_col, right_col = value

            # handle gears
            if part == 2:
                gear_pos = ""
                for i in range(left_col - 1, right_col + 2):
                    gear_pos = max(gear_pos, get_gear_pos(lines, row - 1, i), get_gear_pos(lines, row + 1, i))
                gear_pos = max(gear_pos, get_gear_pos(lines, row, left_col - 1), get_gear_pos(lines, row, right_col + 1))

                if gear_pos != "":
                    gears.append((gear_pos, val))

                continue

            valid = False
            for i in range(left_col - 1, right_col + 2):
                if is_symbol(lines, row - 1, i) or is_symbol(lines, row + 1, i):
                    valid = True
            if is_symbol(lines, row, left_col - 1) or is_symbol(lines, row, right_col + 1):
                valid = True

            if valid:
                valid_numbers.append(val)

    # handle gears
    gears_dict = {}
    for (key, value) in gears:
        if key in gears_dict:
            gears_dict[key].append(value)
        else:
            gears_dict[key] = [value]
    for items in gears_dict:
        if (len(gears_dict[items]) == 2):
            valid_numbers.append(math.prod(gears_dict[items]))

    return sum(valid_numbers)


def is_symbol(lines, row, col):
    return is_in_grid(lines, row, col) and lines[row][col] != "."


def get_gear_pos(lines, row, col):
    if is_in_grid(lines, row, col) and lines[row][col] == "*":
        return f'{row}_{col}'
    return ""


def is_in_grid(lines, row, col):
    min_row = min_col = 0
    max_row = len(lines)-1
    max_col = len(lines[0])-1

    return not (row < min_row or row > max_row or col < min_col or col > max_col)


def read_input(filename):
    with open(filename) as file:
        return [line.rstrip() for line in file]


assert 4361 == main("test/day3.txt", part=1)
print("Day 3, Part 1:", main("input/day3.txt", part=1))

assert 467835 == main("test/day3.txt", part=2)
print("Day 3, Part 2:", main("input/day3.txt", part=2))
