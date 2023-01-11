<?php

$input = <<<INPUT
RDLRUUULRRDLRLLRLDDUDLULULDDULUDRRUURLRLLUULDURRULLRULDRRDLLULLRLLDRLDDRRRRLLRLURRRDRDULRDUULDDDULURUDDRRRUULUDRLLUUURLUDRUUUDRDUULLRLLUDDRURRDDDRDLUUURLRLLUDRURDUDUULDDLLRDURULLLURLDURLUUULDULDDULULLLRRUDLRUURDRDLLURLUDULDUUUURRLDLUDRULUDLDLLDRLDDDRRLLDUDLLRRDDDRLUDURLLLDRUDDLDDRRLUDRRDUDLRRLULDULURULDULUULDRLLDRUUDDRLLUDRULLRRRLRDLRLUDLRULDRDLRDRLRULUDUURRUUULLDDDDUDDLDDDDRRULRDLRDDULLDLDLLDLLDLLDRRDDDRDDLRRDDDRLLLLURRDLRRLDRURDDURDULDDRUURUDUDDDRDRDDRLRRLRULLDRLDLURLRLRUDURRRDLLLUDRLRDLLDDDLLUDRLDRRUUDUUDULDULLRDLUDUURLDDRUDR
URULDDLDDUDLLURLUUUUUULUDRRRDDUDURDRUURLLDRURLUULUDRDRLLDRLDULRULUURUURRLRRDRUUUDLLLLRUDDLRDLLDUDLLRRURURRRUDLRLRLLRULRLRLRDLRLLRRUDDRLRUDULDURDLDLLLRDRURURRULLLDLLRRDRLLDUUDLRUUDDURLLLDUUDLRDDURRDRRULLDRLRDULRRLLRLLLLUDDDRDRULRRULLRRUUDULRRRUDLLUUURDUDLLLURRDDUDLDLRLURDDRRRULRRUDRDRDULURULRUDULRRRLRUDLDDDDRUULURDRRDUDLULLRUDDRRRLUDLRURUURDLDURRDUUULUURRDULLURLRUUUUULULLDRURULDURDDRRUDLRLRRLLLLDDUURRULLURURRLLDRRDDUUDLLUURRDRLLLLRLUDUUUDLRLRRLDURDRURLRLRULURLDULLLRRUUUDLLRRDUUULULDLLDLRRRDUDDLRULLULLULLULRU
DURUUDULRRLULLLDDUDDLRRDURURRRDDRRURDRURDRLULDUDUDUULULDDUURDDULRDUDUDRRURDRDDRLDRDRLDULDDULRULLDULURLUUDUDULRDDRRLURLLRRDLLDLDURULUDUDULDRLLRRRUDRRDDDRRDRUUURLDLURDLRLLDUULLRULLDDDDRULRRLRDLDLRLUURUUULRDUURURLRUDRDDDRRLLRLLDLRULUULULRUDLUDULDLRDDDDDRURDRLRDULRRULRDURDDRRUDRUDLUDLDLRUDLDDRUUULULUULUUUDUULDRRLDUDRRDDLRUULURLRLULRURDDLLULLURLUDLULRLRRDDDDDRLURURURDRURRLLLLURLDDURLLURDULURUUDLURUURDLUUULLLLLRRDUDLLDLUUDURRRURRUUUDRULDDLURUDDRRRDRDULURURLLDULLRDDDRRLLRRRDRLUDURRDLLLLDDDDLUUURDDDDDDLURRURLLLUURRUDLRLRRRURULDRRLULD
LLUUURRDUUDRRLDLRUDUDRLRDLLRDLLDRUULLURLRRLLUDRLDDDLLLRRRUDULDLLLDRLURDRLRRLURUDULLRULLLURRRRRDDDLULURUDLDUDULRRLUDDURRLULRRRDDUULRURRUULUURDRLLLDDRDDLRRULRDRDRLRURULDULRRDRLDRLLDRDURUUULDLLLRDRRRLRDLLUDRDRLURUURDLRDURRLUDRUDLURDRURLRDLULDURDDURUUDRLULLRLRLDDUDLLUUUURLRLRDRLRRRURLRULDULLLLDLRRRULLUUDLDURUUUDLULULRUDDLLDLDLRLDDUDURDRLLRRLRRDDUDRRRURDLRLUUURDULDLURULUDULRRLDUDLDDDUUDRDUULLDDRLRLLRLLLLURDDRURLDDULLULURLRDUDRDDURLLLUDLLLLLUDRDRDLURRDLUDDLDLLDDLUDRRDDLULRUURDRULDDDLLRLDRULURLRURRDDDRLUUDUDRLRRUDDLRDLDULULDDUDURRRURULRDDDUUDULLULDDRDUDRRDRDRDLRRDURURRRRURULLLRRLR
URLULLLDRDDULRRLRLUULDRUUULDRRLLDDDLDUULLDRLULRRDRRDDDRRDLRRLLDDRDULLRRLLUDUDDLDRDRLRDLRDRDDUUDRLLRLULLULRDRDDLDDDRLURRLRRDLUDLDDDLRDLDLLULDDRRDRRRULRUUDUULDLRRURRLLDRDRRDDDURUDRURLUDDDDDDLLRLURULURUURDDUDRLDRDRLUUUULURRRRDRDULRDDDDRDLLULRURLLRDULLUUDULULLLLRDRLLRRRLLRUDUUUULDDRULUDDDRRRULUDURRLLDURRDULUDRUDDRUURURURLRDULURDDDLURRDLDDLRUDUUDULLURURDLDURRDRDDDLRRDLLULUDDDRDLDRDRRDRURRDUDRUURLRDDUUDLURRLDRRDLUDRDLURUDLLRRDUURDUDLUDRRL
INPUT;
$testInput = <<<INPUT
ULL
RRDDD
LURDL
UUUUD
INPUT;

const DIRECTIONS = ['U'=>[-1,0],'R'=>[0,1],'D'=>[1,0],'L'=>[0,-1]];

const KEYPAD = [['1','2','3'], ['4','5','6'], ['7','8','9']];
const START = [1,1];

const REAL_KEYPAD = [
    0 => [                    2 => '1'                    ],
    1 => [          1 => '2', 2 => '3', 3 => '4'          ],
    2 => [0 => '5', 1 => '6', 2 => '7', 3 => '8', 4 => '9'],
    3 => [          1 => 'A', 2 => 'B', 3 => 'C'          ],
    4 => [                    2 => 'D'                    ],
];
const REAL_START = [3,0];

function code(string $input, array $keypad, array $start): string {
    [$y, $x] = $start; // starting at 5
    $code = '';
    foreach(explode(PHP_EOL, $input) as $line) {
        foreach(str_split($line) as $char) {
            $_y = $y + DIRECTIONS[$char][0];
            $_x = $x + DIRECTIONS[$char][1];
            if ($keypad[$_y][$_x] ?? false) {
                $y = $_y;
                $x = $_x;
            }
        }
        $code .= $keypad[$y][$x];
    }
    return $code;
}

# part 1
assert('1985' === $code = code(input: $testInput, keypad: KEYPAD, start: START), "$code does not meet expected 1985");

$s = microtime(true);
printf("part1: code=%s in (%3f seconds)\n", code(input: $input, keypad: KEYPAD, start: START), microtime(true)-$s);

# part 2
assert('5DB3' === $code = code(input: $testInput, keypad: REAL_KEYPAD, start: REAL_START), "$code does not meet expected 5DB3");

$s = microtime(true);
printf("part2: code=%s in (%3f seconds)\n", code(input: $input, keypad: REAL_KEYPAD, start: REAL_START), microtime(true)-$s);