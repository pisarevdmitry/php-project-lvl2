<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\stylish;

function format(array $diff, string $format): string
{
    $result = stylish($diff);
    return $result;
}
