<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;

function format(array $diff, string $format): string
{
    switch ($format) {
        case 'stylish':
            $result = stylish($diff);
            return $result;
        case 'plain':
            $result = plain($diff);
            return $result;
        default:
            throw new \Exception('unsuported format');
    }
}
