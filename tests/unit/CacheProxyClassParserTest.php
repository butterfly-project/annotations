<?php

namespace Butterfly\Component\Annotations\Tests;

use Butterfly\Component\Annotations\CacheProxyClassParser;
use Butterfly\Component\Annotations\IClassParser;

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

        $cacheParser = new CacheProxyClassParser($parser, array());

        $cacheParser->parseClass($className);
    }

    public function testParseClassIfClassInCache()
    {
        $className          = 'Butterfly\Component\Annotations\Tests\Stub\Folder1\Calculator';
        $classFileUpdatedAt = filemtime(__DIR__ . '/Stub/Folder1/Calculator.php');

        $parser = $this->getClassParser();
        $parser
            ->expects($this->never())
            ->method('parseClass')
            ->with($className);

        $cacheParser = new CacheProxyClassParser($parser, array(
            $className => array(
                $classFileUpdatedAt => array()
            )
        ));

        $cacheParser->parseClass($className);
    }

    public function testGetCache()
    {
        $className          = 'Butterfly\Component\Annotations\Tests\Stub\Folder1\Calculator';
        $classFileUpdatedAt = filemtime(__DIR__ . '/Stub/Folder1/Calculator.php');

        $parser = $this->getClassParser();
        $parser
            ->expects($this->once())
            ->method('parseClass')
            ->with($className)
            ->willReturn(array('service' => 'calculator'));

        $cacheParser = new CacheProxyClassParser($parser, array());
        $cacheParser->parseClass($className);

        $expectedCache = array(
            $className => array(
                $classFileUpdatedAt => array(
                    'service' => 'calculator',
                )
            )
        );

        $this->assertEquals($expectedCache, $cacheParser->getCache());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|IClassParser
     */
    protected function getClassParser()
    {
        return $this->getMock('\Butterfly\Component\Annotations\IClassParser');
    }
}
