# import matplotlib.pyplot as plt
import time
from copy import copy, deepcopy


def main(filename):
    lattice = get_lattice(filename)
    lattice, _ = fall(lattice)

    removable_blocks = 0
    moved_blocks = 0
    for k, val in enumerate(lattice):
        variant = deepcopy(lattice)
        variant.remove(val)
        _, nr_of_changes = fall(variant)
        if nr_of_changes == 0:
            removable_blocks += 1
        else:
            moved_blocks += nr_of_changes

    return removable_blocks, moved_blocks


# def plot(lattice):
#     fig = plt.figure(figsize=(4, 4))
#     ax = fig.add_subplot(111, projection='3d')
#     for x, y, z in lattice:
#         ax.plot(list(x), list(y), list(z))
#     plt.show()


def fall(lattice, early_return=False):
    has_change = set()
    lattice = sorted(lattice, key=lambda val: val[2][0])
    for k, (x, y, z) in enumerate(lattice):
        new_z = copy(z)
        while new_z[0] > 1:
            new_z = (new_z[0]-1, new_z[1]-1)
            # check if new_z is possible
            is_valid = True
            xs = set(range(x[0], x[1]+1))
            ys = set(range(y[0], y[1]+1))
            zs = set(range(new_z[0], new_z[1]+1))
            for k_, (x_, y_, z_) in enumerate(lattice):
                if k == k_:
                    continue
                xs_ = range(x_[0], x_[1] + 1)
                ys_ = range(y_[0], y_[1] + 1)
                zs_ = range(z_[0], z_[1] + 1)
                if len(xs.intersection(xs_)) > 0 and len(ys.intersection(ys_)) > 0 and len(zs.intersection(zs_)) > 0:
                    # intersection with another block, so invalid move
                    is_valid = False
                    break
                else:
                    continue
            if is_valid:
                lattice[k] = (x, y, copy(new_z))
                has_change.add(k)
                if early_return:
                    return lattice, has_change
            else:
                break

    return lattice, len(has_change)


def get_lattice(filename):
    with open(filename) as file:
        lattice = []
        for line in file.readlines():
            x, y, z = list(zip(*[[int(j) for j in i.split(',')] for i in line.strip().split('~')]))
            lattice.append((x, y, z))

        return lattice


assert 5, 7 == main("test/day22.txt")
st = time.time()
print("Day 22, Part 1, 2:", main("input/day22.txt"), "in %s seconds " % (time.time() - st))