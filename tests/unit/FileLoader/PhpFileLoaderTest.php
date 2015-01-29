<?php

namespace Butterfly\Component\Annotations\Tests\FileLoader;

use Butterfly\Component\Annotations\FileLoader\FileLoader;

class PhpFileLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFilesFromDir()
    {
        $dirPath        = __DIR__ . '/TestDir';
        $baseNamespaces = 'Butterfly\Component\Annotations\Tests\FileLoader\TestDir';

        $fileLoader = new FileLoader();

        $this->assertFalse(class_exists("$baseNamespaces\\ClassFoo"));
        $this->assertFalse(class_exists("$baseNamespaces\\InnerTestDir\\ClassBar"));
        $this->assertFalse(class_exists("$baseNamespaces\\InnerTestDir\\ClassBaz"));

        $fileLoader->loadFilesFromDir($dirPath);

        $this->assertTrue(class_exists("$baseNamespaces\\ClassFoo"));
        $this->assertTrue(class_exists("$baseNamespaces\\InnerTestDir\\ClassBar"));
        $this->assertTrue(class_exists("$baseNamespaces\\InnerTestDir\\ClassBaz"));
    }
}
