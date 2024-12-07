import time
from re import findall

add = '+'
mul = '*'
con = '||'


def main(filename, ops):
    sum = 0
    for line in read_input(filename):
        numbers = list(map(int, (findall(r'\d+', line))))
        if is_valid(numbers, ops):
            sum += numbers[0]

    return sum


def is_valid(numbers, ops):
    target, current, next = numbers[0], numbers[1], numbers[2:]

    stack = [(current, next, op) for op in ops]
    while stack:
        c, n, op, = stack.pop()

        if op == add:   n_ = c+n[0]
        elif op == mul: n_ = c*n[0]
        elif op == con: n_ = int(str(c)+str(n[0]))
        else: raise Exception("unsupported operand")

        if n_ > target: continue
        if len(n) == 1:
            if n_ == target:
                return True
            else:
                continue

        stack.extend([(n_, n[1:], o) for o in ops])
    return False


def read_input(filename):
    with open(filename) as file:
        return [i.rstrip() for i in file.readlines()]


assert 3749 == main("test/day7.txt", [add, mul])
print("Day7, Part 1:", main("input/day7.txt", [add, mul]))

start = time.time()
assert 11387 == main("test/day7.txt", [add, mul, con])
print("Day7, Part 2:", main("input/day7.txt", [add, mul, con]))
print("Duration: ", time.time()-start)
