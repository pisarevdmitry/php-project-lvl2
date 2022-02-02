<?php

namespace Differ\Differ\Formatters;

use function Differ\Differ\Formatters\Stylish\stylish;
use function Differ\Differ\Formatters\Plain\plain;
use function Differ\Differ\Formatters\Json\json;

function format(array $diff, string $format): string
{
    switch ($format) {
        case 'stylish':
            return stylish($diff);
        case 'plain':
            return plain($diff);
        case 'json':
            return json($diff);
        default:
            throw new \Exception('unsuported format');
    }
}
