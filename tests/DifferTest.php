<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\gendiff;

class DifferTest extends TestCase
{
  private $expectedResult;

  public function setUp(): void
    {
        $this->expectedResult = file_get_contents('./fixtures/expected.txt');
    }
  
    public function testPlainJson()
    {
      $result = gendiff('./fixtures/file1.json', './fixtures/file2.json');
      $this->assertEquals($this->expectedResult,$result);
    }
}