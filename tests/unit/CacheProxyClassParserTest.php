<?php

namespace Butterfly\Component\Annotations\Tests;

use Butterfly\Component\Annotations\CacheProxyClassParser;
use Butterfly\Component\Annotations\ClassParser;
use Butterfly\Component\Annotations\FileLoader\FileLoader;
use Butterfly\Component\Annotations\IClassParser;
use Butterfly\Component\Annotations\Parser\PhpDocParser;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class CacheProxyClassParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseClassIfNotClassInCache()
    {
        $className = 'Butterfly\Component\Annotations\Tests\Stub\Folder1\Calculator';

        $parser = $this->getClassParser();
        $parser
            ->expects($this->once())
            ->method('parseClass')
            ->with($className);

        $cacheParser = new CacheProxyClassParser($parser, []);

        $cacheParser->parseClass($className);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|IClassParser
     */
    protected function getClassParser()
    {
        return $this->getMock('\Butterfly\Component\Annotations\IClassParser');
    }
}
