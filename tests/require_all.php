<?php

require_once sprintf('%s/../vendor/autoload.php', __DIR__);

call_user_func(function () {
    $root = sprintf('%s/../src', __DIR__);

    foreach (find_all($root) as $path) {
        require_once $path;
    }
});

/**
 * 
 * @param string $root
 * @return iterable
 */
function find_all(string $root): iterable
{
    $iterator = new RecursiveDirectoryIterator($root);
    $iterator = new RecursiveIteratorIterator($iterator);
    foreach ($iterator as $fileInfo) {
        $path = $fileInfo->getRealPath();
        if (fnmatch('*.php', $path)) {
            yield $path;
        }
    }
}
