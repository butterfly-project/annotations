<?php

namespace Butterfly\Component\Annotations\Tests;

use Butterfly\Component\Annotations\ClassFinder\ClassFinder;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class ClassFinderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFilesFromDir()
    {
        $finder  = new ClassFinder(array('php'));
        $classes = $finder->findClassesInDir(__DIR__ . '/TestDir');

        $baseNamespaces = 'Butterfly\Component\Annotations\Tests\ClassFinder\TestDir';

        $this->assertTrue(in_array("$baseNamespaces\\ClassFoo", $classes));
        $this->assertTrue(in_array("$baseNamespaces\\InnerTestDir\\ClassBar", $classes));
        $this->assertTrue(in_array("$baseNamespaces\\InnerTestDir\\ClassBaz", $classes));
    }
}
