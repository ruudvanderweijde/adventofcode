import time
import json
from math import prod


def part1(filename):
    workflows, ratings = get_input(filename)

    total = 0
    for r in ratings:
        wf_name = 'in'
        rule_index = 0
        while wf_name in workflows:
            raw_rule = workflows[wf_name][rule_index]
            if ':' in raw_rule:
                rule , go_to = raw_rule.split(':')
                if (rule[1] == '>' and r[rule[0]] > int(rule[2:])) or (rule[1] == '<' and r[rule[0]] < int(rule[2:])):
                    rule_index = 0
                    wf_name = go_to
                else:
                    rule_index += 1

            else:
                rule_index = 0
                wf_name = raw_rule

        if wf_name == 'A':
            total += sum(r.values())

    return total


def part2(filename):
    workflows, ratings = get_input(filename)
    formulas = set()
    queue = [('in', 0, [])]
    while len(queue) > 0:
        wf_name, idx, rules = queue.pop(0)
        if wf_name in ['A', 'R']:
            if wf_name == 'A':
                formulas.add(','.join(rules))
            continue

        raw_rule = workflows[wf_name][idx]
        if ':' in raw_rule:
            rule, go_to = raw_rule.split(':')
            queue.append((wf_name, idx + 1, rules + ['!'+rule]))
            queue.append((go_to, 0, rules + [rule]))
        else:
            queue.append((raw_rule, 0, rules))

    total = 0
    for i in formulas:
        accepted = {
            'x': [1, 4000],
            'm': [1, 4000],
            'a': [1, 4000],
            's': [1, 4000],
        }
        for j in i.split(','):
            if j[0] == '!':
                if '<' in j:
                    accepted[j[1]][0] = max(accepted[j[1]][0], int(j[3:]))
                elif '>' in j:
                    accepted[j[1]][1] = min(accepted[j[1]][1], int(j[3:]))
                else:
                    assert False
            else:
                if '<' in j:
                    accepted[j[0]][1] = min(accepted[j[0]][1], int(j[2:])-1)
                elif '>' in j:
                    accepted[j[0]][0] = max(accepted[j[0]][0], int(j[2:])+1)
                else:
                    assert False

        ranges = ([i[1]-i[0]+1 for _, i in accepted.items()])
        if all(val > 0 for val in ranges):
            total += prod(ranges)

    return total


def get_input(filename):
    with open(filename) as file:
        raw_workflows, raw_ratings = file.read().strip().split('\n\n')

        workflows = {}
        for wf in raw_workflows.split('\n'):
            name, rest = wf.split('{')
            workflows[name] = rest.strip('}').split(',')

        replacements = {
            '=': ':',
            'x': '"x"',
            'm': '"m"',
            'a': '"a"',
            's': '"s"',
        }
        for old, new in replacements.items():
            raw_ratings = raw_ratings.replace(old, new)

        ratings = [json.loads(i) for i in raw_ratings.split('\n')]

    return workflows, ratings


assert 19114 == part1("test/day19.txt")
st = time.time()
print("Day 19, Part 1:", part1("input/day19.txt"), " in %s seconds " % (time.time() - st))

assert 167409079868000 == part2("test/day19.txt")
st = time.time()
print("Day 19, Part 2:", part2("input/day19.txt"), " in %s seconds " % (time.time() - st))
