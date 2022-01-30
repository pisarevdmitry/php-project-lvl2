<?php

namespace Differ;

use function Differ\Parsers\parseData;
use function Differ\Comparator\buildDiff;
use function Differ\Formatters\format;

function gendiff(string $filepath1, string $filepath2, string $format = 'stylish'): string
{
    if (!file_exists($filepath1) || !file_exists($filepath2)) {
        throw new \Exception('file not exists');
    }
    $content1 = file_get_contents($filepath1);
    $content2 = file_get_contents($filepath2);
    $ext1 = pathinfo($filepath1)['extension'];
    $ext2 = pathinfo($filepath2)['extension'];
    $data1 = parseData($content1, $ext1);
    $data2 = parseData($content2, $ext2);
    $diff = buildDiff($data1, $data2);
    $result = format($diff, $format);
    return $result;
}
