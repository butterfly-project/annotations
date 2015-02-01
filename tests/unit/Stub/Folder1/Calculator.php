<?php

namespace Butterfly\Component\Annotations\Tests\Stub\Folder1;

/**
 * @class-annotation1 value1
 * @class-annotation2 value2
 */
class Calculator
{
    /**
     * @property-annotation1 value1
     * @property-annotation2 value2
     *
     * @var string
     */
    protected $property;

    /**
     * @method-annotation1 value1
     * @method-annotation2 value2
     *
     * @param string $property
     */
    protected function setProperty($property)
    {
        $this->property = $property;
    }
}
