def main(filename, part=1):
    raw_input = read_input(filename)
    seeds = [int(i) for i in raw_input.pop(0).split(":")[1].strip().split()]
    if part == 2:
        it = iter(seeds)
        new_seeds = []
        for x in it:
            new_seeds.extend(list(range(x, x+next(it))))
        seeds = new_seeds

    maps = []
    for raw_map in raw_input:
        numbers = raw_map.split(":\n")[1].split("\n")
        maps.append([[int(num) for num in string.split()] for string in numbers])

    for idx, item in enumerate(seeds):
        for m in maps:
            for numrs in m:
                dest_start, src_start, length = numrs
                if src_start <= item < src_start+length:
                    item += dest_start-src_start
                    break
        seeds[idx] = item

    return min(seeds)


def read_input(filename):
    with open(filename) as file:
        return file.read().split("\n\n")


assert 35 == main("test/day5.txt")
print("Day 5, Part 1:", main("input/day5.txt"))

assert 46 == main("test/day5.txt", part=2)
# disabled because it takes about 2 hours to run, 20 minutes using pypy
# print("Day 5, Part 2:", main("input/day5.txt", part=2))
