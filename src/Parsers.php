<?php

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseJson(string|false $data): array
{
    return json_decode($data, true);
}

function parseYaml(string|false $data): array
{
    return Yaml::parse($data);
}

function parseData(string|false $data, string $format): array
{
    switch ($format) {
        case 'json':
            return parseJson($data);
        case 'yaml':
        case 'yml':
            return parseYaml($data);
        default:
            throw new \Exception('unsupoted format');
    }
}
