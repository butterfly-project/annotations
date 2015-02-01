<?php

namespace Butterfly\Component\Annotations;

use Butterfly\Component\Annotations\FileLoader\IFileLoader;
use Butterfly\Component\Annotations\Parser\IPhpDocParser;

class ClassParser
{
    /**
     * @var IPhpDocParser
     */
    protected $phpDocParser;

    /**
     * @var IFileLoader
     */
    protected $fileLoader;

    /**
     * @param IPhpDocParser $phpDocParser
     * @param IFileLoader $fileLoader
     */
    public function __construct(IPhpDocParser $phpDocParser, IFileLoader $fileLoader)
    {
        $this->phpDocParser = $phpDocParser;
        $this->fileLoader   = $fileLoader;
    }

    /**
     * @param string $path
     * @return array
     */
    public function parseClassesInDir($path)
    {
        $classes = $this->findClassesInDir($path);

        return $this->parseClasses($classes);
    }

    /**
     * @param string $path
     * @return array
     */
    protected function findClassesInDir($path)
    {
        $classesBefore = get_declared_classes();
        $this->fileLoader->loadFilesFromDir($path);
        $classesAfter = get_declared_classes();

        return array_diff($classesAfter, $classesBefore);
    }

    /**
     * @param array $classesNames
     * @return array
     */
    protected function parseClasses(array $classesNames)
    {
        $annotations = array();
        foreach ($classesNames as $className) {
            $annotations[$className] = $this->parseClass($className);
        }

        return $annotations;
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
