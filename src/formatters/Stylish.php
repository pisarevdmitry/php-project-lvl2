<?php

namespace Differ\Formatters\Stylish;

function stringifyValue(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if ($value === null) {
        return 'null';
    }
    return (string)$value;
}

function calcIndent(int $depth, bool $isCompared = false): string
{
    $baseIndent = 4;
    $comparedMargin = 2;
    $indent = $isCompared ? ($depth * $baseIndent) - $comparedMargin : $depth * $baseIndent;
    return str_repeat(' ', $indent);
}

function formatNotCompared(array $data, int $depth): string
{
    $keys = array_keys($data);
    sort($keys);
    $mapped = array_map(function ($key) use ($data, $depth) {
        $space = calcIndent($depth);
        return is_object($data[$key])
            ? "{$space}{$key}: {\n" . formatNotCompared((array)$data[$key], $depth + 1) . "\n{$space}}"
            : "{$space}{$key}: " . stringifyValue($data[$key]) ;
    }, $keys);
    return implode("\n", $mapped);
}

function styleChangedValue(string $key, mixed $value, int $depth, string $symbol): string
{
    $indentCompared = calcIndent($depth, true);
    return is_array($value)
        ? "{$indentCompared}{$symbol} {$key}: {\n"
            . formatNotCompared((array)$value, $depth + 1) . "\n" . calcIndent($depth) . '}'
        : "{$indentCompared}{$symbol} {$key}: " . stringifyValue($value);
}

function buildFormat(array $children, int $depth): string
{
    $result = array_map(function (mixed $node) use ($depth) {
        ['type' => $type, 'name' => $name] = $node;
        switch ($type) {
            case 'unchanged':
                return calcIndent($depth) . "{$name}: {$node['value']}";
            case 'added':
                return styleChangedValue($name, $node['value'], $depth, '+');
            case 'deleted':
                return styleChangedValue($name, $node['value'], $depth, '-');
            case 'changed':
                ['oldValue' => $oldValue, 'newValue' => $newValue] = $node;
                $deleted = styleChangedValue($name, $oldValue, $depth, '-');
                $added = styleChangedValue($name, $newValue, $depth, '+');
                return "{$deleted}\n{$added}";
            case 'parent':
                $space = calcIndent($depth);
                ['children' => $nodeChildren] = $node;
                return "{$space}{$name}: {\n" . buildFormat($nodeChildren, $depth + 1) . "\n{$space}}";
            default:
                throw new \Exception("unsuported {$type} type");
        }
    }, $children);
    return implode("\n", $result);
}

function stylish(array $diff)
{
    $result = buildFormat($diff, 1);
    return "{\n{$result}\n}";
}
