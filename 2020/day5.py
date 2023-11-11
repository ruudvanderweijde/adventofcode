def seat(boarding_pass):
    rows = list(range(128))
    cols = list(range(8))

    for i in boarding_pass:
        row_mid = len(rows) // 2
        col_mid = len(cols) // 2
        match i:
            case "F":
                rows = rows[:row_mid]
            case "B":
                rows = rows[row_mid:]
            case "L":
                cols = cols[:col_mid]
            case "R":
                cols = cols[col_mid:]

    return rows.pop() * 8 + cols.pop()


def read_input(filename):
    with open(filename) as file:
        return [line.rstrip() for line in file]


assert 357 == seat("FBFBBFFRLR")
assert 567 == seat("BFFFBBFRRR")
assert 119 == seat("FFFBBBFRRR")
assert 820 == seat("BBFFBBFRLL")


def part1():
    return max([seat(i) for i in read_input("input/day5.txt")])


def part2():
    seats = [seat(i) for i in read_input("input/day5.txt")]
    for x in range(min(seats), max(seats)):
        if x not in seats:
            return x


print("Day 5, Part 1:", part1())
print("Day 5, Part 2:", part2())
