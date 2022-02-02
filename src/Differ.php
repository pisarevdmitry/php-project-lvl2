<?php

namespace Differ\Differ;

use function Differ\Differ\Parsers\parseData;
use function Differ\Differ\Comparator\buildDiff;
use function Differ\Differ\Formatters\format;

function gendiff(string $filepath1, string $filepath2, string $format = 'stylish'): string
{
    if (!file_exists($filepath1) || !file_exists($filepath2)) {
        throw new \Exception('file not exists');
    }
    $content1 = file_get_contents($filepath1);
    $content2 = file_get_contents($filepath2);
    $pathInfo1 = pathinfo($filepath1);
    $pathInfo2 = pathinfo($filepath2);
    $ext1 = array_key_exists('extension', $pathInfo1) ? $pathInfo1['extension'] : '';
    $ext2 =  array_key_exists('extension', $pathInfo2) ? $pathInfo2['extension'] : '';
    $data1 = parseData((string)$content1, $ext1);
    $data2 = parseData((string)$content2, $ext2);
    $diff = buildDiff($data1, $data2);
    $result = format($diff, $format);
    return $result;
}
