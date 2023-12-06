import time


def main(tuples):
    totals = 1
    for size, dist in tuples:
        wins = 0
        for i in range(size + 1):
            if (size - i) * i > dist:
                wins += 1
        if wins > 0:
            totals *= wins

    return totals


def read_input(filename, part=1):
    with open(filename) as file:
        content = file.read().split('\n')
        if part == 2:
            return tuple(zip(*[[int(i.split(':')[1].replace(' ', ''))] for i in content]))
        return tuple(zip(*[[int(j) for j in i.split(':')[1].split()] for i in content]))


assert 288 == main(read_input("test/day6.txt"))
st = time.time()
print("Day 6, Part 1:", main(read_input("input/day6.txt")), " in %s seconds " % (time.time() - st))

assert 71503 == main(read_input("test/day6.txt", part=2))
st = time.time()
print("Day 6, Part 2:", main(read_input("input/day6.txt", part=2)), " in %s seconds " % (time.time() - st))
