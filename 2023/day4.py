def part1(filename):
    cards = read_input(filename)
    total = 0
    for line in cards:
        _, numbers = line.strip().split(':')
        score = get_score(numbers)
        if score > 0:
            total += 2 ** (score-1)

    return total


def part2(filename):
    cards = enumerate(read_input(filename))
    scores = {}
    for id, line in cards:
        card_nr, numbers = line.strip().split(':')
        card_nr = int(card_nr.split()[1])
        score = get_score(numbers)
        scores[card_nr] = list(range(card_nr+1, card_nr+score+1))

    total = 0
    for k in scores.keys():
        total += get_total(scores, k)

    return total


def get_total(scores, k):
    total = 1
    for c in scores[k]:
        total += get_total(scores, c)
    return total


def get_score(numbers):
    score = 0
    w, m = numbers.strip().split('|')
    winners = w.strip().split()
    for my_number in m.strip().split():
        if my_number in winners:
            score += 1
    return score


def read_input(filename):
    with open(filename) as file:
        return [line.rstrip() for line in file]


assert 13 == part1("test/day4.txt")
print("Day 4, Part 1:", part1("input/day4.txt"))

assert 30 == part2("test/day4.txt")
print("Day 4, Part 2:", part2("input/day4.txt"))