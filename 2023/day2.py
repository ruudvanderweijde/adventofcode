def part1(filename):
    games = read_input(filename)
    sum_ids=0
    for (game, sets) in games:
        valid = True
        for bags in sets.split(";"):
            for item in bags.split(","):
                count, color = item.strip().split(" ")
                if color == "red" and int(count) > 12: valid = False
                if color == "green" and int(count) > 13: valid = False
                if color == "blue" and int(count) > 14: valid = False
        if valid:
            sum_ids+=int(game.split(" ")[1])

    return sum_ids


def part2(filename):
    games = read_input(filename)
    sum_ids = 0
    for (game, sets) in games:
        red = green = blue = 0
        for bags in sets.split(";"):
            for item in bags.split(","):
                count, color = item.strip().split(" ")
                if color == "red": red = max(red, int(count))
                if color == "green": green = max(green, int(count))
                if color == "blue": blue = max(blue, int(count))
        sum_ids += red*green*blue
    return sum_ids


def read_input(filename):
    with open(filename) as file:
        return [line.rstrip().split(":") for line in file]


assert 8 == part1("test/day2.txt")
print("Day 2, Part 1:", part1("input/day2.txt"))

assert 2286 == part2("test/day2.txt")
print("Day 2, Part 2:", part2("input/day2.txt"))