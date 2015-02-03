<?php

namespace Butterfly\Component\Annotations\Tests;

use Butterfly\Component\Annotations\ClassParser;
use Butterfly\Component\Annotations\FileLoader\FileLoader;
use Butterfly\Component\Annotations\Parser\PhpDocParser;

class ClassParserTest extends \PHPUnit_Framework_TestCase
{
    protected $expectedClassAnnotations = array(
        'class'      => array(
            'class-annotation1' => 'value1',
            'class-annotation2' => 'value2',
        ),
        'properties' => array(
            'property' => array(
                'property-annotation1' => 'value1',
                'property-annotation2' => 'value2',
                'var'                  => 'string'
            ),
        ),
        'methods'    => array(
            'setProperty' => array(
                'method-annotation1' => 'value1',
                'method-annotation2' => 'value2',
                'param'              => 'string $property'
            ),
        ),
    );

    public function testParseClassesInDir()
    {
        $parser = $this->getClassParser();

        $result = $parser->parseClassesInDir(__DIR__ . '/Stub/Folder1');

        $expected = array(
            'Butterfly\Component\Annotations\Tests\Stub\Folder1\Calculator' => $this->expectedClassAnnotations
        );

        $this->assertEquals($expected, $result);
    }

    public function testParseClass()
    {
        $parser = $this->getClassParser();

        $annotations = $parser->parseClass('Butterfly\Component\Annotations\Tests\Stub\Folder1\Calculator');

        $this->assertEquals($this->expectedClassAnnotations, $annotations);
    }

    public function testParseWithEmptyPropertiesOrMethods()
    {
        $parser = $this->getClassParser();

        $annotations = $parser->parseClass('Butterfly\Component\Annotations\Tests\Stub\Folder2\EmptyCalculator');

        $expected = array(
            'class'      => array(),
            'properties' => array(),
            'methods'    => array(),
        );

        $this->assertEquals($expected, $annotations);
    }

    /**
     * @return ClassParser
     */
    protected function getClassParser()
    {
        $phpDocParser = new PhpDocParser();
        $fileLoader   = new FileLoader();

        return new ClassParser($phpDocParser, $fileLoader);
    }
    
    public function testCreateInstance()
    {
        $parser = ClassParser::createInstance();

        $this->assertInstanceOf('\Butterfly\Component\Annotations\ClassParser', $parser);
    }
}
