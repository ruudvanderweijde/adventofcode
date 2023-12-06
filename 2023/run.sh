PYTHON_VERSION=3.11
PYTHON_IMAGE=${PYTHON_IMAGE:-"python:${PYTHON_VERSION:-"3.11"}-alpine"}

DIRECTORY=$(cd "$(dirname "$0")" && pwd)

docker pull -q "${PYTHON_IMAGE}" > /dev/null

for path in "${DIRECTORY}"/day*.py; do
  file=$(basename "${path}")
  echo "--[ $file ]--"
  docker run -it --rm --name "python-aoc-2023-${file}" \
    -v "$DIRECTORY":/code \
    -w /code \
    "${PYTHON_IMAGE}" python "${file}"
  echo
done
