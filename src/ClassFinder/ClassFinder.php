<?php

namespace Butterfly\Component\Annotations\ClassFinder;

class ClassFinder
{
    /**
     * @var array
     */
    protected $fileExtensions;

    /**
     * @param array $fileExtensions
     */
    public function __construct(array $fileExtensions)
    {
        $this->fileExtensions = $fileExtensions;
    }

    /**
     * @param string $path
     * @return array
     */
    public function findClassesInDir($path)
    {
        $files = $this->getFilesFromDir($path);

        foreach ($files as $file) {
            require_once $file;
        }

        $loadedClasses = get_declared_classes();

        $classes = array();

        foreach ($loadedClasses as $loadedClass) {
            $reflectionClass = new \ReflectionClass($loadedClass);

            if (in_array($reflectionClass->getFileName(), $files)) {
                $classes[] = $loadedClass;
            }
        }

        return $classes;
    }

    /**
     * @param string $path
     * @return array
     */
    protected function getFilesFromDir($path)
    {
        $iterator = new \DirectoryIterator($path);

        $files = array();

        foreach ($iterator as $item) {
            if($item->isDot()) {
                continue;
            }

            if ($item->isDir()) {
                $files = array_merge($files, $this->getFilesFromDir($item->getRealPath()));
            } elseif ($item->isFile() && in_array($item->getExtension(), $this->fileExtensions)) {
                $files[] = $item->getRealPath();
            }
        }

        return $files;
    }
}
