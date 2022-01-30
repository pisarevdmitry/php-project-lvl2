<?php

namespace Differ\Comparator;

function buildDiff(array $data1, array $data2): array
{
    $mergedKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($mergedKeys);
    $result = array_map(function ($key) use ($data1, $data2) {
        if (!array_key_exists($key, $data1)) {
            return [
                'name' => $key,
                'type' => 'added',
                'value' => is_object($data2[$key]) ? (array)$data2[$key] : $data2[$key]
            ];
        }
        if (!array_key_exists($key, $data2)) {
            return [
                'name' => $key,
                'type' => 'deleted',
                'value' => is_object($data1[$key]) ? (array)$data1[$key] : $data1[$key]
            ];
        }
        if (is_object($data1[$key]) && is_object($data2[$key])) {
            return [
                'name' => $key,
                'type' => 'parent',
                'children' => buildDiff((array)$data1[$key], (array)$data2[$key])
            ];
        }
        if ($data1[$key] !== $data2[$key]) {
            return [
                'name' => $key,
                'type' => 'changed',
                'oldValue' => is_object($data1[$key]) ? (array)$data1[$key] : $data1[$key],
                'newValue' => is_object($data2[$key]) ? (array)$data2[$key] : $data2[$key]
            ];
        }
        return [
            'name' => $key,
            'type' => 'unchanged',
            'value' => is_object($data1[$key]) ? (array)$data1[$key] : $data1[$key]
        ];
    }, $mergedKeys);
    return $result;
}
