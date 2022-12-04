#!/usr/bin/env bash

# part one
cat input | tr '\n' '+' | sed -e 's/++/\n/g' -e 's/+$/\n/' | bc | sort -n | tail -n 1

# part two
cat input | tr '\n' '+' | sed -e 's/++/\n/g' -e 's/+$/\n/' | bc | sort -n | tail -n 3 | awk '{s+=$1} END {print s}'
