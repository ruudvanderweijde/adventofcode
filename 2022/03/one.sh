#!/usr/bin/env bash

# generated using: echo -e 0 \\b{a..z} \\b{A..Z}
points=abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ

function getPoints() {
  echo ${points%%"${1}"*} | wc -c
}

function score() {
  score=0;
  while read -r i; do
    score=$((score + "$(getPoints "$(tr -dc "$(echo ${i:0:${#i}/2})" <<< "$(echo ${i:${#i}/2})" | tr -s 'a-z' | tr -s 'A-Z')")"))
  done < "$1"
  echo $score;
}

echo "Running the test..."
testScore="$(score "input-test")"
[ "157" = "$testScore" ] || { echo "Test score didn't match 157, got $testScore"; exit 4; }

echo "Running the real deal..."
score "input"
