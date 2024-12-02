def main(filename, part):
    input = read_input(filename)

    if part == 1:
        return sum([is_safe(l) for l in input])
    else:
        safe = 0
        for l in input:
            if is_safe(l):
                safe += 1
                continue

            for i in range(0, len(l)):
                l_ = l.copy()
                del l_[i]
                if is_safe(l_):
                    safe += 1
                    break

        return safe

def is_safe(l):
    if l[0] > l[-1]:
        l = list(reversed(l))
    if list(sorted(l)) != l:
        return False

    for i in range(len(l) - 1):
        if 1 <= l[i + 1] - l[i] <= 3:
            if i == len(l) - 2:
                return True
        else:
            break

    return False


def read_input(filename):
    with open(filename) as file:
        return [[int(k) for k in j] for j in [i.split() for i in [line.rstrip() for line in file]]]


assert 2 == main("test/day2.txt", 1)
print("Day 2, Part 1:", main("input/day2.txt", 1))

assert 4 == main("test/day2.txt", 2)
print("Day 2, Part 2:", main("input/day2.txt", 2))