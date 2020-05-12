<?php

namespace Butterfly\Component\Annotations;

use Butterfly\Component\Annotations\Parser\IPhpDocParser;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class ClassParser implements IClassParser
{
    /**
     * @var IPhpDocParser
     */
    protected $phpDocParser;

    /**
     * @param IPhpDocParser $phpDocParser
     */
    public function __construct(IPhpDocParser $phpDocParser)
    {
        $this->phpDocParser = $phpDocParser;
    }

    /**
     * @param string $className
     * @return array
     */
    public function parseClass($className)
    {
        $reflectionClass = new \ReflectionClass($className);

        $annotations = array();
        $annotations['class'] = $this->phpDocParser->parse($reflectionClass->getDocComment());

        $annotations['properties'] = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $annotations['properties'][$property->getName()] = $this->phpDocParser->parse($property->getDocComment());
        }

        $annotations['methods'] = array();
        foreach ($reflectionClass->getMethods() as $method) {
            $annotations['methods'][$method->getName()] = $this->phpDocParser->parse($method->getDocComment());
        }

        return $annotations;
    }
}
