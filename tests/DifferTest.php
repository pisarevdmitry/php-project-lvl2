<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\gendiff;

class DifferTest extends TestCase
{
  private $expectedResult;
  private $expectedComplex;

  public function setUp(): void
    {
        $this->expectedResult = file_get_contents('./fixtures/expected.txt');
        $this->expectedComplex = file_get_contents('./fixtures/expected2.txt');
    }
  
    public function testPlainJson()
    {
      $result = gendiff('./fixtures/plain1.json', './fixtures/plain2.json');
      $this->assertEquals($this->expectedResult, $result);
    }
    public function testPlainYaml()
    {
      $result = gendiff('./fixtures/plain1.yaml', './fixtures/plain2.yml');
      $this->assertEquals($this->expectedResult, $result);
    }
    public function testComplexStylish() {
      $result = gendiff('./fixtures/complex1.json', './fixtures/complex2.json');
      $this->assertEquals($this->expectedComplex, $result);
    }
}