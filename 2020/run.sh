PYTHON_VERSION=3.11
PYTHON_IMAGE="python:${PYTHON_VERSION:-"3.11"}-alpine"
DIRECTORY="${PWD}"

docker pull -q "${PYTHON_IMAGE}" > /dev/null

for path in "${DIRECTORY}"/day*.py; do
  file=$(basename "${path}")
  echo "--[ $file ]--"
  docker run -it --rm --name "python-aoc-2020-$(basename "${file}")" \
    -v "$PWD":/code \
    -w /code \
    "${PYTHON_IMAGE}" python "${file}"
  echo
done