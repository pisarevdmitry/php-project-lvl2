<?php

namespace Differ;

function stringifyValue($value) {
  if(is_bool($value)) {
    return $value ? 'true' : 'false';
  }
  return $value;
}

function gendiff(string $filepath1, string $filepath2, string $format = 'stylish') :string
{
  if(!file_exists($filepath1) || !file_exists($filepath2)) {
    throw new \Exception('file not exists');
  }
  $content1 = file_get_contents($filepath1);
  $content2 = file_get_contents($filepath2);
  $data1 = (array)json_decode($content1);
  $data2 = (array)json_decode($content2);
  $merged = array_merge($data1, $data2);
  $mergedKeys = array_keys($merged);
  sort($mergedKeys);
  $mapped = array_map(function ($key) use($data1, $data2){
    $indent = str_repeat(' ', 2);
    if (!array_key_exists($key, $data1)) {
      $value = stringifyValue($data2[$key]);
      return "{$indent}+ {$key}: {$value}";
    }
    if (!array_key_exists($key, $data2)) {
      $value = stringifyValue($data1[$key]);
      return "{$indent}- {$key}: {$value}";
    }
    if ($data1[$key] !== $data2[$key]) {
      $value1 = stringifyValue($data1[$key]);
      $value2 = stringifyValue($data2[$key]);
      return "{$indent}- {$key}: {$value1}\n{$indent}+ {$key}: {$value2}";
    }
    $value = stringifyValue($data1[$key]);
    return "{$indent}  {$key}: {$value}";
  }, $mergedKeys);
  $result = implode("\n", $mapped);
  return "{\n{$result}\n}";
}