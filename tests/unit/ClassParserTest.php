<?php

namespace Butterfly\Component\Annotations\Tests;

use Butterfly\Component\Annotations\ClassParser;
use Butterfly\Component\Annotations\FileLoader\PhpFileLoader;
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

    public function testParseDirectories()
    {
        $parser = $this->getClassParser();

        $result = $parser->parseDirectories(array(
            __DIR__ . '/Stub'
        ));

        $expected = array(
            'Butterfly\Component\Annotations\Tests\Stub\Calculator' => $this->expectedClassAnnotations
        );

        $this->assertEquals($expected, $result);
    }

    public function testParseClass()
    {
        $parser = $this->getClassParser();

        require_once __DIR__ . '/Stub/Calculator.php';

        $annotations = $parser->parse('Butterfly\Component\Annotations\Tests\Stub\Calculator');

        $this->assertEquals($this->expectedClassAnnotations, $annotations);
    }

    /**
     * @return ClassParser
     */
    protected function getClassParser()
    {
        $phpDocParser = new PhpDocParser();
        $fileLoader   = new PhpFileLoader();

        return new ClassParser($phpDocParser, $fileLoader);
    }
}