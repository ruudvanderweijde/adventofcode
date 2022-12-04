#!/usr/bin/env bash

tmpdir=$(mktemp -d)
trap 'rm -rf "$tmpdir"' EXIT

# generated using: echo -e 0 \\b{a..z} \\b{A..Z}
points=abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ

function getPoints() {
  echo ${points%%"${1}"*} | wc -c
}

function score() {
  cp "$1" "$tmpdir/"; cd "$tmpdir"; split -l3 "$1"

  score=0
  for i in $tmpdir/x*; do
    score=$((score + "$(getPoints "$(tr -dc "$(sed '1q;d' $i)" <<< "$(tr -dc "$(sed '2q;d' $i)" <<< "$(sed '3q;d' $i)")" | tr -s 'a-z' | tr -s 'A-Z')")"))
  done

  echo $score;
}

echo "Running the test..."
testScore="$(score "input-test")"
[ "70" = "$testScore" ] || { echo "Test score didn't match 70, got $testScore"; exit 4; }

echo "Running the real deal..."
score "input"
