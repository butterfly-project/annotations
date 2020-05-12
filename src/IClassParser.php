<?php

namespace Butterfly\Component\Annotations;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
interface IClassParser
{
    /**
     * @param string $className
     * @return array
     */
    public function parseClass($className);
}