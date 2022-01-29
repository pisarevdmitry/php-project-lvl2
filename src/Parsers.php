<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseJson(string $data): array
{
    return (array)json_decode($data);
}

function parseYaml(string $data): array
{
    return (array)Yaml::parse($data);
}

function parseData(string $data, string $format): array
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
