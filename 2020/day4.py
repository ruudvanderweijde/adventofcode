import re

optional = r'^cid:'
part1 = [
    r'^byr:',
    r'^ecl:',
    r'^eyr:',
    r'^hcl:',
    r'^hgt:',
    r'^iyr:',
    r'^pid:',
]
part2 = [
    r'^byr:(19[2-9][0-9]|200[0-2])$',
    r'^ecl:(amb|blu|brn|gry|grn|hzl|oth)$',
    r'^eyr:(202[0-9]|2030)$',
    r'^hcl:#[0-9a-f]{6}$',
    r'^hgt:(1[5-8][0-9]cm|19[0-3]cm|59in|6[0-9]in|7[0-6]in)$',
    r'^iyr:(201[0-9]|2020)$',
    r'^pid:[0-9]{9}$',
]


def is_valid_password(values, regexes):
    filtered = sorted([i for i in values if re.match(optional, i) is None])
    if len(filtered) != len(regexes):
        return False

    for key, item in enumerate(filtered):
        if re.match(regexes[key], item) is None:
            return False

    return True


def main(filename, regexes):
    passports = [item for item in read_input(filename) if is_valid_password(item, regexes)]
    return len(passports)


def read_input(filename):
    with open(filename) as file:
        return [sorted(line.replace("\n", " ").split(" ")) for line in file.read().split("\n\n")]


assert 2 == (result1 := main("test/day4.txt", part1))
print("Day 4, Part 1:", main("input/day4.txt", part1))

assert 0 == (result2 := main("test/day4_part2_invalid.txt", part2)), f'Got: {result2}'
assert 4 == (result2 := main("test/day4_part2_valid.txt", part2)), f'Got: {result2}'
print("Day 4, Part 2:", main("input/day4.txt", part2))
