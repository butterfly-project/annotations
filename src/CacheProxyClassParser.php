<?php

namespace Butterfly\Component\Annotations;

use Butterfly\Component\Annotations\Parser\IPhpDocParser;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class CacheProxyClassParser implements IClassParser
{
    /**
     * @var IClassParser
     */
    protected $classParser;

    /**
     * @var array
     */
    protected $cache;

    /**
     * @param IClassParser $classParser
     * @param array $cache
     */
    public function __construct(IClassParser $classParser, array $cache)
    {
        $this->classParser = $classParser;
        $this->cache       = $cache;
    }

    /**
     * @param string $className
     * @return array
     */
    public function parseClass($className)
    {
        $reflectionClass = new \ReflectionClass($className);
        $lastUpdatedAt   = filemtime($reflectionClass->getFileName());

        if (empty($this->cache[$className]) || empty($this->cache[$className][$lastUpdatedAt])) {
            $this->cache[$className] = [];
            $this->cache[$className][$lastUpdatedAt] = $this->classParser->parseClass($className);
        }

        return $this->cache[$className][$lastUpdatedAt];
    }
}
