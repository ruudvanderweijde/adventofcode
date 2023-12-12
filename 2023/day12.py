# solution taken from https://github.com/jonathanpaulson/AdventOfCode/blob/master/2023/12.py
import time
cache = {}


def main(filename, size):
    total = 0
    for str, sizes in get_input(filename, size):
        cache.clear()
        print(str, sizes)
        total += solve(str, sizes, 0, 0, 0)
    return total


def solve(str, blocks, str_index, block_index, block_match):
    cache_key = (str_index, block_index, block_match)
    if cache_key in cache:
        return cache[cache_key]

    if str_index == len(str):
        # we reached the end
        return 1 if (
            # all blocks matches
            (block_index == len(blocks) and block_match == 0) or
            # block matches on the last char
            (block_index == len(blocks) - 1 and blocks[block_index] == block_match)
        ) else 0

    ans = 0
    for c in ['.', '#']:
        if str[str_index] == c or str[str_index] == '?':
            if c == '.' and block_match == 0:
                # if we hit a dot, and we're not in a match, move to the next pos
                ans += solve(str, blocks, str_index + 1, block_index, 0)
            elif c == '.' and block_match > 0 and block_index < len(blocks) and blocks[block_index] == block_match:
                # if we hit a dot, but we fully matched a block, move to the next block
                ans += solve(str, blocks, str_index + 1, block_index + 1, 0)
            elif c == '#':
                # if we hit a damaged spring, increment the block match
                ans += solve(str, blocks, str_index + 1, block_index, block_match + 1)

    # cache the current result
    cache[cache_key] = ans

    return ans


def get_input(filename, size):
    with open(filename) as file:
        ret = []
        for l in file.readlines():
            str, nums = l.rstrip().split(' ')
            if size > 1:
                str = '?'.join([str] * size)
                nums = ','.join([nums] * size)
            numbers = [int(n) for n in nums.split(',')]
            ret.append((str, numbers))
        return ret


assert 21 == main("test/day12.txt", size=1)
st = time.time()
print("Day 12, Part 1:", main("input/day12.txt", size=1), " in %s seconds " % (time.time() - st))

assert 525152 == main("test/day12.txt", size=5)
st = time.time()
print("Day 12, Part 2:", main("input/day12.txt", size=5), " in %s seconds " % (time.time() - st))
