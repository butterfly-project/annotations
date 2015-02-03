<?php

namespace Butterfly\Component\Annotations\Tests\FileLoader;

use Butterfly\Component\Annotations\FileLoader\FileLoader;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class PhpFileLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFilesFromDir()
    {
        $dirPath        = __DIR__ . '/TestDir';
        $baseNamespaces = 'Butterfly\Component\Annotations\Tests\FileLoader\TestDir';

        $fileLoader = new FileLoader();

        $classes = get_declared_classes();
        $this->assertFalse(in_array("$baseNamespaces\\ClassFoo", $classes));
        $this->assertFalse(in_array("$baseNamespaces\\InnerTestDir\\ClassBar", $classes));
        $this->assertFalse(in_array("$baseNamespaces\\InnerTestDir\\ClassBaz", $classes));

        $fileLoader->loadFilesFromDir($dirPath);

        $classes = get_declared_classes();
        $this->assertTrue(in_array("$baseNamespaces\\ClassFoo", $classes));
        $this->assertTrue(in_array("$baseNamespaces\\InnerTestDir\\ClassBar", $classes));
        $this->assertTrue(in_array("$baseNamespaces\\InnerTestDir\\ClassBaz", $classes));
    }
}
