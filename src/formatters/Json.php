<?php

namespace Differ\Differ\Formatters\Json;

function json(array $diff): string
{
    return json_encode($diff);
}
