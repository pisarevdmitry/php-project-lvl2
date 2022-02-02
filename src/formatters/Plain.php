<?php

namespace Differ\Differ\Formatters\Plain;

function formatValue(mixed $value): string
{
    if (is_array($value)) {
        return '[complex value]';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    return "'{$value}'";
}

function buildFormat(array $children, string $path): string
{
    $result = array_map(function (mixed $node) use ($path) {
        ['type' => $type, 'name' => $name] = $node;
        switch ($type) {
            case 'unchanged':
                return null;
            case 'added':
                return  "Property '{$path}{$name}' was added with value: " . formatValue($node['value']);
            case 'deleted':
                return "Property '{$path}{$name}' was removed";
            case 'changed':
                ['oldValue' => $oldValue, 'newValue' => $newValue] = $node;
                $deleted = formatValue($oldValue);
                $added = formatValue($newValue);
                return "Property '{$path}{$name}' was updated. From {$deleted} to {$added}";
            case 'parent':
                ['children' => $nodeChildren] = $node;
                return buildFormat($nodeChildren, "{$path}{$name}.");
            default:
                throw new \Exception("unsuported {$type} type");
        }
    }, $children);
    $filtered = array_filter($result, (function (mixed $elem) {
        return $elem !== null;
    }));
    return implode("\n", $filtered);
}


function plain(array $diff): string
{
    return buildFormat($diff, '');
}
