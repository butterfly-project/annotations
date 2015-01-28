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
     * @param array $dirs
     * @return array
     */
    public function parseDirectories(array $dirs)
    {
        $classes = $this->loadClassesFromDir($dirs);

        return $this->parseClasses($classes);
    }

    /**
     * @param array $dirs
     * @return array
     */
    protected function loadClassesFromDir(array $dirs)
    {
        $classesBefore = get_declared_classes();
        $this->loadDirectories($dirs);
        $classesAfter = get_declared_classes();

        return array_diff($classesAfter, $classesBefore);
    }

    /**
     * @param array $dirs
     */
    protected function loadDirectories(array $dirs)
    {
        foreach ($dirs as $dir) {
            $this->fileLoader->loadDirectory($dir);
        }
    }

    /**
     * @param array $classesnames
     * @return array
     */
    protected function parseClasses(array $classesnames)
    {
        $annotations = array();
        foreach ($classesnames as $classname) {
            $annotations[$classname] = $this->parse($classname);
        }

        return $annotations;
    }

    /**
     * @param string $classname
     * @return array
     */
    public function parse($classname)
    {
        $reflectionClass = new \ReflectionClass($classname);

        $annotations = array();
        $annotations['class'] = $this->phpDocParser->parse($reflectionClass->getDocComment());

        foreach ($reflectionClass->getProperties() as $property) {
            $annotations['properties'][$property->getName()] = $this->phpDocParser->parse($property->getDocComment());
        }

        foreach ($reflectionClass->getMethods() as $method) {
            $annotations['methods'][$method->getName()] = $this->phpDocParser->parse($method->getDocComment());
        }

        return $annotations;
    }
}
