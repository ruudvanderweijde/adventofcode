<?php

class Dir
{
    public function __construct(
        public string $name,
        public array  $children = [],
        public ?Dir   $parent = null,
        public int    $size = 0,
    ) {}

    public function addDir(Dir $d): void
    {
        $d->parent = $this;
        $this->children["dir_".$d->name] = $d;
    }

    public function addFile(File $f): void
    {
        $f->parent = $this;
        $this->children["dir_".$f->name] = $f;
        $this->size += $f->size;

        $parent = $this->parent;
        while ($parent !== null) {
            $parent->size += $f->size;
            $parent = $parent->parent;
        }
    }
}

class File
{
    public function __construct(
        public string $name,
        public int    $size,
        public ?Dir    $parent = null,
    ) {}
}

$filename = $argv[1] ?? 'input-test';

$root = new Dir(name: 'root');
$currentDir = $root;

foreach (array_map('rtrim', explode(PHP_EOL, rtrim(file_get_contents($filename)))) as $cmd) {
    if (preg_match('/^\$ cd (.+)$/', $cmd, $matches)) {
        // navigate to dir
        if ($matches[1] === '..') {
            $currentDir = $currentDir->parent;
            continue;
        }
        $dir = new Dir(name: $matches[1], parent: $currentDir);
        $currentDir->children["dir_".$matches[1]] = $dir;
        $currentDir = $dir;
    } else if (preg_match('/^\$ ls$/', $cmd, $matches)) {
        // no need for action...
    } else if (preg_match('/^dir (\w+)$/', $cmd, $matches)) {
        $currentDir->addDir(new Dir(name: $matches[1]));
    } else if (preg_match('/^(.+) (.+)$/', $cmd, $matches)) {
        $currentDir->addFile(new file(name: $matches[2], size: $matches[1]));
    } else {
        throw new Exception('failed to parse: ' . $cmd);
    }
}

function printDir(Dir $dir, $depth=0): void {
    echo sprintf('%s- %s (dir=%d)' . PHP_EOL, str_repeat(" ", $depth * 2), $dir->name, $dir->size);
    ++$depth;
    foreach ($dir->children as $child) {
        if ($child instanceof Dir) {
            printDir($child, $depth);
        } else {
            echo sprintf('%s- %s (file=%d)' . PHP_EOL, str_repeat(" ", $depth * 2), $child->name, $child->size);
        }
    }
}

if ($filename === 'input-test') {
    printDir($root);
}

function getBigDirs(Dir $dir, int $needed): array {
    $return = [];
    if ($dir->parent && $dir->size > $needed) {
        $return[] = $dir->size;
    }
    foreach ($dir->children as $child) {
        if ($child instanceof Dir) {
            $return = [...$return, ...getBigDirs($child, $needed)];
        }
    }
    return $return;
}

$needed = 30000000 - (70000000 - $root->size);
echo min(getBigDirs($root, $needed)) . PHP_EOL;
