<?php

$root = './testDir';

if (isset($argv[1]) && is_dir($argv[1]))
    $root = $argv[1];

$count = 0;

$parentDirs = [$root];

function fileCount($filename)
{
     if($content = file_get_contents($filename)) {
         $content = explode(' ', $content);
         return array_sum($content);
     }

     return 0;
}

do {
    var_dump($parentDirs);
    $newLevelDirs =  [];
    foreach ($parentDirs as $parentDir) {
        foreach (array_diff(scandir($parentDir) ? : ['.', '..'],  ['.', '..']) as $newLevelDir) {
            $fullPath = "$parentDir/$newLevelDir";
            if (is_dir($fullPath)) {
                $newLevelDirs[] = $fullPath;
            } else if ($newLevelDir == 'count' && is_readable($fullPath)) {
                $count += fileCount($fullPath);
            }
        }
    }
    $parentDirs = $newLevelDirs;

} while($parentDirs);

echo $count;
