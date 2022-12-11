# Day 11: Monkey in the Middle

<details>
<summary>Part one</summary>
As you finally start making your way upriver, you realize your pack is much lighter than you remember. Just then, one of the items from your pack goes flying overhead. Monkeys are playing Keep Away with your missing things!

To get your stuff back, you need to be able to predict where the monkeys will throw your items. After some careful observation, you realize the monkeys operate based on how worried you are about each item.

You take some notes (your puzzle input) on the items each monkey currently has, how worried you are about those items, and how the monkey makes decisions based on your worry level. For example:

```
Monkey 0:
  Starting items: 79, 98
  Operation: new = old * 19
  Test: divisible by 23
    If true: throw to monkey 2
    If false: throw to monkey 3

Monkey 1:
  Starting items: 54, 65, 75, 74
  Operation: new = old + 6
  Test: divisible by 19
    If true: throw to monkey 2
    If false: throw to monkey 0

Monkey 2:
  Starting items: 79, 60, 97
  Operation: new = old * old
  Test: divisible by 13
    If true: throw to monkey 1
    If false: throw to monkey 3

Monkey 3:
  Starting items: 74
  Operation: new = old + 3
  Test: divisible by 17
    If true: throw to monkey 0
    If false: throw to monkey 1
```

Each monkey has several attributes:

    Starting items lists your worry level for each item the monkey is currently holding in the order they will be inspected.
    Operation shows how your worry level changes as that monkey inspects an item. (An operation like new = old * 5 means that your worry level after the monkey inspected the item is five times whatever your worry level was before inspection.)
    Test shows how the monkey uses your worry level to decide where to throw an item next.
        If true shows what happens with an item if the Test was true.
        If false shows what happens with an item if the Test was false.

After each monkey inspects an item but before it tests your worry level, your relief that the monkey's inspection didn't damage the item causes your worry level to be divided by three and rounded down to the nearest integer.

The monkeys take turns inspecting and throwing items. On a single monkey's turn, it inspects and throws all of the items it is holding one at a time and in the order listed. Monkey 0 goes first, then monkey 1, and so on until each monkey has had one turn. The process of each monkey taking a single turn is called a round.

When a monkey throws an item to another monkey, the item goes on the end of the recipient monkey's list. A monkey that starts a round with no items could end up inspecting and throwing many items by the time its turn comes around. If a monkey is holding no items at the start of its turn, its turn ends.

In the above example, the first round proceeds as follows:

```
Monkey 0:
  Monkey inspects an item with a worry level of 79.
    Worry level is multiplied by 19 to 1501.
    Monkey gets bored with item. Worry level is divided by 3 to 500.
    Current worry level is not divisible by 23.
    Item with worry level 500 is thrown to monkey 3.
  Monkey inspects an item with a worry level of 98.
    Worry level is multiplied by 19 to 1862.
    Monkey gets bored with item. Worry level is divided by 3 to 620.
    Current worry level is not divisible by 23.
    Item with worry level 620 is thrown to monkey 3.
Monkey 1:
  Monkey inspects an item with a worry level of 54.
    Worry level increases by 6 to 60.
    Monkey gets bored with item. Worry level is divided by 3 to 20.
    Current worry level is not divisible by 19.
    Item with worry level 20 is thrown to monkey 0.
  Monkey inspects an item with a worry level of 65.
    Worry level increases by 6 to 71.
    Monkey gets bored with item. Worry level is divided by 3 to 23.
    Current worry level is not divisible by 19.
    Item with worry level 23 is thrown to monkey 0.
  Monkey inspects an item with a worry level of 75.
    Worry level increases by 6 to 81.
    Monkey gets bored with item. Worry level is divided by 3 to 27.
    Current worry level is not divisible by 19.
    Item with worry level 27 is thrown to monkey 0.
  Monkey inspects an item with a worry level of 74.
    Worry level increases by 6 to 80.
    Monkey gets bored with item. Worry level is divided by 3 to 26.
    Current worry level is not divisible by 19.
    Item with worry level 26 is thrown to monkey 0.
Monkey 2:
  Monkey inspects an item with a worry level of 79.
    Worry level is multiplied by itself to 6241.
    Monkey gets bored with item. Worry level is divided by 3 to 2080.
    Current worry level is divisible by 13.
    Item with worry level 2080 is thrown to monkey 1.
  Monkey inspects an item with a worry level of 60.
    Worry level is multiplied by itself to 3600.
    Monkey gets bored with item. Worry level is divided by 3 to 1200.
    Current worry level is not divisible by 13.
    Item with worry level 1200 is thrown to monkey 3.
  Monkey inspects an item with a worry level of 97.
    Worry level is multiplied by itself to 9409.
    Monkey gets bored with item. Worry level is divided by 3 to 3136.
    Current worry level is not divisible by 13.
    Item with worry level 3136 is thrown to monkey 3.
Monkey 3:
  Monkey inspects an item with a worry level of 74.
    Worry level increases by 3 to 77.
    Monkey gets bored with item. Worry level is divided by 3 to 25.
    Current worry level is not divisible by 17.
    Item with worry level 25 is thrown to monkey 1.
  Monkey inspects an item with a worry level of 500.
    Worry level increases by 3 to 503.
    Monkey gets bored with item. Worry level is divided by 3 to 167.
    Current worry level is not divisible by 17.
    Item with worry level 167 is thrown to monkey 1.
  Monkey inspects an item with a worry level of 620.
    Worry level increases by 3 to 623.
    Monkey gets bored with item. Worry level is divided by 3 to 207.
    Current worry level is not divisible by 17.
    Item with worry level 207 is thrown to monkey 1.
  Monkey inspects an item with a worry level of 1200.
    Worry level increases by 3 to 1203.
    Monkey gets bored with item. Worry level is divided by 3 to 401.
    Current worry level is not divisible by 17.
    Item with worry level 401 is thrown to monkey 1.
  Monkey inspects an item with a worry level of 3136.
    Worry level increases by 3 to 3139.
    Monkey gets bored with item. Worry level is divided by 3 to 1046.
    Current worry level is not divisible by 17.
    Item with worry level 1046 is thrown to monkey 1.
```

After round 1, the monkeys are holding items with these worry levels:

```
Monkey 0: 20, 23, 27, 26
Monkey 1: 2080, 25, 167, 207, 401, 1046
Monkey 2: 
Monkey 3: 
```

Monkeys 2 and 3 aren't holding any items at the end of the round; they both inspected items during the round and threw them all before the round ended.

This process continues for a few more rounds:

```
After round 2, the monkeys are holding items with these worry levels:
Monkey 0: 695, 10, 71, 135, 350
Monkey 1: 43, 49, 58, 55, 362
Monkey 2: 
Monkey 3: 

After round 3, the monkeys are holding items with these worry levels:
Monkey 0: 16, 18, 21, 20, 122
Monkey 1: 1468, 22, 150, 286, 739
Monkey 2: 
Monkey 3: 

After round 4, the monkeys are holding items with these worry levels:
Monkey 0: 491, 9, 52, 97, 248, 34
Monkey 1: 39, 45, 43, 258
Monkey 2: 
Monkey 3: 

After round 5, the monkeys are holding items with these worry levels:
Monkey 0: 15, 17, 16, 88, 1037
Monkey 1: 20, 110, 205, 524, 72
Monkey 2: 
Monkey 3: 

After round 6, the monkeys are holding items with these worry levels:
Monkey 0: 8, 70, 176, 26, 34
Monkey 1: 481, 32, 36, 186, 2190
Monkey 2: 
Monkey 3: 

After round 7, the monkeys are holding items with these worry levels:
Monkey 0: 162, 12, 14, 64, 732, 17
Monkey 1: 148, 372, 55, 72
Monkey 2: 
Monkey 3: 

After round 8, the monkeys are holding items with these worry levels:
Monkey 0: 51, 126, 20, 26, 136
Monkey 1: 343, 26, 30, 1546, 36
Monkey 2: 
Monkey 3: 

After round 9, the monkeys are holding items with these worry levels:
Monkey 0: 116, 10, 12, 517, 14
Monkey 1: 108, 267, 43, 55, 288
Monkey 2: 
Monkey 3: 

After round 10, the monkeys are holding items with these worry levels:
Monkey 0: 91, 16, 20, 98
Monkey 1: 481, 245, 22, 26, 1092, 30
Monkey 2: 
Monkey 3: 

...

After round 15, the monkeys are holding items with these worry levels:
Monkey 0: 83, 44, 8, 184, 9, 20, 26, 102
Monkey 1: 110, 36
Monkey 2: 
Monkey 3: 

...

After round 20, the monkeys are holding items with these worry levels:
Monkey 0: 10, 12, 14, 26, 34
Monkey 1: 245, 93, 53, 199, 115
Monkey 2: 
Monkey 3: 
```

Chasing all of the monkeys at once is impossible; you're going to have to focus on the two most active monkeys if you want any hope of getting your stuff back. Count the total number of times each monkey inspects items over 20 rounds:

```
Monkey 0 inspected items 101 times.
Monkey 1 inspected items 95 times.
Monkey 2 inspected items 7 times.
Monkey 3 inspected items 105 times.
```

In this example, the two most active monkeys inspected items 101 and 105 times. The level of monkey business in this situation can be found by multiplying these together: 10605.

Figure out which monkeys to chase by counting how many items they inspect over 20 rounds. What is the level of monkey business after 20 rounds of stuff-slinging simian shenanigans?
</details>

<details>
<summary>Part two</summary>
You're worried you might not ever get your items back. So worried, in fact, that your relief that a monkey's inspection didn't damage an item no longer causes your worry level to be divided by three.

Unfortunately, that relief was all that was keeping your worry levels from reaching ridiculous levels. You'll need to find another way to keep your worry levels manageable.

At this rate, you might be putting up with these monkeys for a very long time - possibly 10000 rounds!

With these new rules, you can still figure out the monkey business after 10000 rounds. Using the same example above:

```
== After round 1 ==
Monkey 0 inspected items 2 times.
Monkey 1 inspected items 4 times.
Monkey 2 inspected items 3 times.
Monkey 3 inspected items 6 times.

== After round 20 ==
Monkey 0 inspected items 99 times.
Monkey 1 inspected items 97 times.
Monkey 2 inspected items 8 times.
Monkey 3 inspected items 103 times.

== After round 1000 ==
Monkey 0 inspected items 5204 times.
Monkey 1 inspected items 4792 times.
Monkey 2 inspected items 199 times.
Monkey 3 inspected items 5192 times.

== After round 2000 ==
Monkey 0 inspected items 10419 times.
Monkey 1 inspected items 9577 times.
Monkey 2 inspected items 392 times.
Monkey 3 inspected items 10391 times.

== After round 3000 ==
Monkey 0 inspected items 15638 times.
Monkey 1 inspected items 14358 times.
Monkey 2 inspected items 587 times.
Monkey 3 inspected items 15593 times.

== After round 4000 ==
Monkey 0 inspected items 20858 times.
Monkey 1 inspected items 19138 times.
Monkey 2 inspected items 780 times.
Monkey 3 inspected items 20797 times.

== After round 5000 ==
Monkey 0 inspected items 26075 times.
Monkey 1 inspected items 23921 times.
Monkey 2 inspected items 974 times.
Monkey 3 inspected items 26000 times.

== After round 6000 ==
Monkey 0 inspected items 31294 times.
Monkey 1 inspected items 28702 times.
Monkey 2 inspected items 1165 times.
Monkey 3 inspected items 31204 times.

== After round 7000 ==
Monkey 0 inspected items 36508 times.
Monkey 1 inspected items 33488 times.
Monkey 2 inspected items 1360 times.
Monkey 3 inspected items 36400 times.

== After round 8000 ==
Monkey 0 inspected items 41728 times.
Monkey 1 inspected items 38268 times.
Monkey 2 inspected items 1553 times.
Monkey 3 inspected items 41606 times.

== After round 9000 ==
Monkey 0 inspected items 46945 times.
Monkey 1 inspected items 43051 times.
Monkey 2 inspected items 1746 times.
Monkey 3 inspected items 46807 times.

== After round 10000 ==
Monkey 0 inspected items 52166 times.
Monkey 1 inspected items 47830 times.
Monkey 2 inspected items 1938 times.
Monkey 3 inspected items 52013 times.
```

After 10000 rounds, the two most active monkeys inspected items 52166 and 52013 times. Multiplying these together, the level of monkey business in this situation is now 2713310158.

Worry levels are no longer divided by three after each item is inspected; you'll need to find another way to keep your worry levels manageable. Starting again from the initial state in your puzzle input, what is the level of monkey business after 10000 rounds?
</details>

Answers using php:
```
docker container run --rm -v $(pwd):/code/ --workdir /code php:8.2.0RC7-cli php /code/one.php input-test debug

> Round 1
Monkey [0]: 20, 23, 27, 26 (inspections = 2)
Monkey [1]: 2080, 25, 167, 207, 401, 1046 (inspections = 4)
Monkey [2]:  (inspections = 3)
Monkey [3]:  (inspections = 5)

> Round 2
Monkey [0]: 695, 10, 71, 135, 350 (inspections = 6)
Monkey [1]: 43, 49, 58, 55, 362 (inspections = 10)
Monkey [2]:  (inspections = 4)
Monkey [3]:  (inspections = 10)

> Round 3
Monkey [0]: 16, 18, 21, 20, 122 (inspections = 11)
Monkey [1]: 1468, 22, 150, 286, 739 (inspections = 15)
Monkey [2]:  (inspections = 4)
Monkey [3]:  (inspections = 15)

> Round 4
Monkey [0]: 491, 9, 52, 97, 248, 34 (inspections = 16)
Monkey [1]: 39, 45, 43, 258 (inspections = 20)
Monkey [2]:  (inspections = 4)
Monkey [3]:  (inspections = 20)

> Round 5
Monkey [0]: 15, 17, 16, 88, 1037 (inspections = 22)
Monkey [1]: 20, 110, 205, 524, 72 (inspections = 24)
Monkey [2]:  (inspections = 4)
Monkey [3]:  (inspections = 26)

> Round 6
Monkey [0]: 8, 70, 176, 26, 34 (inspections = 27)
Monkey [1]: 481, 32, 36, 186, 2190 (inspections = 29)
Monkey [2]:  (inspections = 5)
Monkey [3]:  (inspections = 31)

> Round 7
Monkey [0]: 162, 12, 14, 64, 732, 17 (inspections = 32)
Monkey [1]: 148, 372, 55, 72 (inspections = 34)
Monkey [2]:  (inspections = 5)
Monkey [3]:  (inspections = 36)

> Round 8
Monkey [0]: 51, 126, 20, 26, 136 (inspections = 38)
Monkey [1]: 343, 26, 30, 1546, 36 (inspections = 38)
Monkey [2]:  (inspections = 5)
Monkey [3]:  (inspections = 42)

> Round 9
Monkey [0]: 116, 10, 12, 517, 14 (inspections = 43)
Monkey [1]: 108, 267, 43, 55, 288 (inspections = 43)
Monkey [2]:  (inspections = 5)
Monkey [3]:  (inspections = 47)

> Round 10
Monkey [0]: 91, 16, 20, 98 (inspections = 48)
Monkey [1]: 481, 245, 22, 26, 1092, 30 (inspections = 48)
Monkey [2]:  (inspections = 6)
Monkey [3]:  (inspections = 52)

> Round 11
Monkey [0]: 162, 83, 9, 10, 366, 12, 34 (inspections = 52)
Monkey [1]: 193, 43, 207 (inspections = 54)
Monkey [2]:  (inspections = 6)
Monkey [3]:  (inspections = 56)

> Round 12
Monkey [0]: 66, 16, 71 (inspections = 59)
Monkey [1]: 343, 176, 20, 22, 773, 26, 72 (inspections = 57)
Monkey [2]:  (inspections = 6)
Monkey [3]:  (inspections = 63)

> Round 13
Monkey [0]: 116, 60, 8, 9, 259, 10, 26, 34 (inspections = 62)
Monkey [1]: 140, 150 (inspections = 64)
Monkey [2]:  (inspections = 6)
Monkey [3]:  (inspections = 66)

> Round 14
Monkey [0]: 48, 52, 17 (inspections = 70)
Monkey [1]: 245, 127, 20, 547, 22, 55, 72 (inspections = 66)
Monkey [2]:  (inspections = 6)
Monkey [3]:  (inspections = 74)

> Round 15
Monkey [0]: 83, 44, 8, 184, 9, 20, 26, 102 (inspections = 73)
Monkey [1]: 110, 36 (inspections = 73)
Monkey [2]:  (inspections = 6)
Monkey [3]:  (inspections = 77)

> Round 16
Monkey [0]: 14, 17 (inspections = 81)
Monkey [1]: 481, 176, 93, 389, 20, 43, 55, 216 (inspections = 75)
Monkey [2]:  (inspections = 7)
Monkey [3]:  (inspections = 85)

> Round 17
Monkey [0]: 162, 60, 33, 131, 8, 16, 20, 74 (inspections = 83)
Monkey [1]: 30, 36 (inspections = 83)
Monkey [2]:  (inspections = 7)
Monkey [3]:  (inspections = 87)

> Round 18
Monkey [0]: 12, 14, 17, 34 (inspections = 91)
Monkey [1]: 343, 127, 70, 277, 43, 157 (inspections = 85)
Monkey [2]:  (inspections = 7)
Monkey [3]:  (inspections = 95)

> Round 19
Monkey [0]: 116, 44, 25, 94, 16, 54 (inspections = 95)
Monkey [1]: 26, 30, 36, 72 (inspections = 91)
Monkey [2]:  (inspections = 7)
Monkey [3]:  (inspections = 99)

> Round 20
Monkey [0]: 10, 12, 14, 26, 34 (inspections = 101)
Monkey [1]: 245, 93, 53, 199, 115 (inspections = 95)
Monkey [2]:  (inspections = 7)
Monkey [3]:  (inspections = 105)

10605

> docker container run --rm -v $(pwd):/code/ --workdir /code php:8.2.0RC7-cli php /code/one.php input
121450
```

Part two

After trying many solutions with arithmetic variation, I looked up the logic for the solution.
```
> docker container run --rm -v $(pwd):/code/ --workdir /code php:8.2.0RC7-cli php /code/two.php input-test print assert | pbcopy

> Round 1
Monkey [0]: 60, 71, 81, 80 (inspections = 2)
Monkey [1]: 77, 1504, 1865, 6244, 3603, 9412 (inspections = 4)
Monkey [2]:  (inspections = 3)
Monkey [3]:  (inspections = 6)

> Round 20
Monkey [0]: 7723, 61208, 82089, 95446, 84350 (inspections = 99)
Monkey [1]: 84591, 55901, 10567, 20200, 60575 (inspections = 97)
Monkey [2]:  (inspections = 8)
Monkey [3]:  (inspections = 103)

> Round 1000
Monkey [0]: 84464, 48934, 39396, 19275, 48307, 82374, 27591 (inspections = 5204)
Monkey [1]: 12752, 69429, 31980 (inspections = 4792)
Monkey [2]:  (inspections = 199)
Monkey [3]:  (inspections = 5192)

> Round 2000
Monkey [0]: 70043, 40327, 18249, 24424, 25374 (inspections = 10419)
Monkey [1]: 66693, 70664, 42468, 95193, 53621 (inspections = 9577)
Monkey [2]:  (inspections = 392)
Monkey [3]:  (inspections = 10391)

> Round 3000
Monkey [0]: 69378, 34665, 28737, 93584, 25203, 13056 (inspections = 15638)
Monkey [1]: 48928, 42924, 49479, 58048 (inspections = 14358)
Monkey [2]:  (inspections = 587)
Monkey [3]:  (inspections = 15593)

> Round 4000
Monkey [0]: 16425, 18401, 77700, 17299, 33924 (inspections = 20858)
Monkey [1]: 70037, 91393, 81950, 48301, 4544 (inspections = 19138)
Monkey [2]:  (inspections = 780)
Monkey [3]:  (inspections = 20797)

> Round 5000
Monkey [0]: 68637, 40688, 4335 (inspections = 26075)
Monkey [1]: 18243, 20504, 60689, 34659, 6330, 47028, 84154 (inspections = 23921)
Monkey [2]:  (inspections = 974)
Monkey [3]:  (inspections = 26000)

> Round 6000
Monkey [0]: 83932, 65806, 29269, 25355 (inspections = 31294)
Monkey [1]: 84667, 38402, 85484, 49251, 15659, 91412 (inspections = 28702)
Monkey [2]:  (inspections = 1165)
Monkey [3]:  (inspections = 31204)

> Round 7000
Monkey [0]: 77757, 86744, 76484, 68289 (inspections = 36508)
Monkey [1]: 83812, 54001, 60290, 7736, 19877, 52652 (inspections = 33488)
Monkey [2]:  (inspections = 1360)
Monkey [3]:  (inspections = 36400)

> Round 8000
Monkey [0]: 66699, 34399, 43139, 54919, 91222 (inspections = 41728)
Monkey [1]: 68954, 2416, 5361, 80620, 93521 (inspections = 38268)
Monkey [2]:  (inspections = 1553)
Monkey [3]:  (inspections = 41606)

> Round 9000
Monkey [0]: 65407, 56363, 20377, 49618, 63121 (inspections = 46945)
Monkey [1]: 9142, 20219, 45546, 75585, 25349 (inspections = 43051)
Monkey [2]:  (inspections = 1746)
Monkey [3]:  (inspections = 46807)

> Round 10000
Monkey [0]: 63602, 56040, 11941, 10573, 61607 (inspections = 52166)
Monkey [1]: 90861, 86149, 27648, 21340, 76915 (inspections = 47830)
Monkey [2]:  (inspections = 1938)
Monkey [3]:  (inspections = 52013)

2713310158

> docker container run --rm -v $(pwd):/code/ --workdir /code php:8.2.0RC7-cli php /code/two.php input
28244037010

```
