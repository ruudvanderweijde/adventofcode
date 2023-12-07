import time

rank_p1 = [*'23456789TJQKA']
rank_p2 = [*'J23456789TQKA']


def get_seconds_rank(v, part=1):
    if part == 2:
        return [rank_p2.index(i) for i in v]
    return [rank_p1.index(i) for i in v]


def main(filename, part=1):
    total = 0
    iteration = 1
    for v in sorted(read_input(filename), key=lambda x: (get_rank(x[0], part), get_seconds_rank(x[0], part))):
        total += iteration * int(v[1])
        iteration += 1
    return total


def get_rank(cards, part):
    if part == 1 or not 'J' in cards or cards == 'JJJJJ':
        return get_rank_for_cards(cards)

    return max([get_rank_for_cards(cards.replace('J', i)) for i in set([*cards.replace('J', '')])])


def get_rank_for_cards(cards):
    cards_list = [*cards]
    dupes = {i: cards_list.count(i) for i in cards_list}
    flipped_dupes = {v: k for k, v in dupes.items()}

    if len(dupes) == 1: return 6                             # five of a kind
    if len(dupes) == 2 and 4 in flipped_dupes: return 5      # four of a kind
    if len(dupes) == 2: return 4                             # full house
    if len(dupes) == 3 and 2 not in flipped_dupes: return 3  # three of a kind
    if len(dupes) == 3: return 2                             # two pair
    if len(dupes) == 4: return 1                             # pair
    return 0                                                 # highcard


def read_input(filename):
    with open(filename) as file:
        return [i.split() for i in file.readlines()]


assert 6440 == main("test/day7.txt")
st = time.time()
print("Day 7, Part 1:", main("input/day7.txt"), " in %s seconds " % (time.time() - st))

assert 5905 == main("test/day7.txt", part=2)
st = time.time()
print("Day 7, Part 2:", main("input/day7.txt", part=2), "in %s seconds " % (time.time() - st))