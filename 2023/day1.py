from re import findall

def main(filename, pattern):
    return sum([int(get_num(num[0]) + get_num(num[-1])) for num in (read_input(filename, pattern))])


def read_input(filename, pattern):
    with open(filename) as file:
        return [findall(pattern, line.rstrip()) for line in file]


def get_num(num):
    match num:
        case "one": return "1"
        case "two": return "2"
        case "three": return "3"
        case "four": return "4"
        case "five": return "5"
        case "six": return "6"
        case "seven": return "7"
        case "eight": return "8"
        case "nine": return "9"
        case _: return num


assert 142 == main("test/day1.txt", pattern="[0-9]")
print("Day 1, Part 1:", main("input/day1.txt", pattern="[0-9]"))

assert 281 == main(filename="test/day1_part2.txt", pattern="(?=([0-9]|one|two|three|four|five|six|seven|eight|nine))")
print("Day 1, Part 2:", main(filename="input/day1.txt", pattern="(?=([0-9]|one|two|three|four|five|six|seven|eight|nine))"))
