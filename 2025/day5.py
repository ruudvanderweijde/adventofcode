import time


def main(filename, part):
    ranges, ids = read_input(filename)

    return part1(ids, ranges) if part == 1 else part2(ranges)


def part1(ids: list[int], ranges: list[list[int]]) -> int:
    fresh = 0
    for i in ids:
        is_fresh = False
        for r in ranges:
            if r[0] <= i <= r[1]:
                is_fresh = True
                break
        if is_fresh:
            fresh += 1
    return fresh


def part2(ranges: list[list[int]]) -> int:
    # Brute force approach did not work, as expected!
    # n = set()
    # for l, r in ranges:
    #     n.update(range(l, r+1))
    # return len(n)

    # Merge ranges
    total = 0
    for l,r in merge_overlap(ranges):
        total += 1 + r - l
    return total


# Ref: https://www.geeksforgeeks.org/dsa/merging-intervals/
def merge_overlap(arr):
    n = len(arr)

    arr.sort()
    res = []

    # Checking for all possible overlaps
    for i in range(n):
        start = arr[i][0]
        end = arr[i][1]

        # Skipping already merged intervals
        if res and res[-1][1] >= end:
            continue

        # Find the end of the merged range
        for j in range(i + 1, n):
            if arr[j][0] <= end:
                end = max(end, arr[j][1])
        res.append([start, end])

    return res


def read_input(filename):
    with open(filename) as file:
        ranges, ids = file.read().split("\n\n")
        return [[int(x) for x in r.split('-')] for r in ranges.split('\n')], [int(i) for i in ids.split('\n')]


start = time.time()
assert 3 == main("test/day5.txt", 1)
print("day 5, Part 1:", main("input/day5.txt", 1))
print("Duration: ", time.time()-start)

start = time.time()
assert 14 == main("test/day5.txt", 2)
print("day 5, Part 2:", main("input/day5.txt", 2))
print("Duration: ", time.time()-start)