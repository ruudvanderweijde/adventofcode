from functools import lru_cache
import time


def part1(filename, blinks):
    numbers = read_input(filename)
    for _ in range(blinks):
        numbers = blink(numbers)
    return len(numbers)


def blink(numbers):
    numbers_ = []
    for number in numbers:
        if number == '0':
            numbers_.append('1')
        elif len(number)%2==0:
            numbers_.extend([number[:len(number) // 2], str(int(number[len(number) // 2:]))])
        else:
            numbers_.append(str(int(number) * 2024))
    # print(' '.join(numbers_))
    return numbers_


def part2(filename, blinks):
    return sum(blink_rec(n, 0, blinks) for n in read_input(filename))

@lru_cache(maxsize=None)
def blink_rec(i, c, m):
    if c == m: return 1
    if i == '0':
        return blink_rec('1', c+1, m)
    elif len(i)%2==0:
        return blink_rec(i[:len(i) // 2], c+1, m) + blink_rec(str(int(i[len(i) // 2:])), c+1, m)
    else:
        return blink_rec(str(2024*int(i)), c+1, m)

def read_input(filename):
    with open(filename) as file:
        return [i.split() for i in file.readlines()][0]


assert 22 == part1("test/day11.txt", 6)
assert 55312 == part1("test/day11.txt", 25)
print("Day11, Part 1:", part1("input/day11.txt", 25))

start = time.time()
assert 22 == part2("test/day11.txt", 6)
assert 55312 == part2("test/day11.txt", 25)
print("Day11, Part 2:", part2("input/day11.txt", 75))
print("Duration: ", time.time()-start)