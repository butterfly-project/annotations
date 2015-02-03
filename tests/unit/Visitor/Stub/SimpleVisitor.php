<?php

namespace Butterfly\Component\Annotations\Tests\Visitor\Stub;

use Butterfly\Component\Annotations\Visitor\IAnnotationVisitor;

class SimpleVisitor implements IAnnotationVisitor
{
    /**
     * @var array
     */
    protected $result;

    /**
     * Clean visitor
     */
    public function clean()
    {
        $this->result = array();
    }

    /**
     * Visit one class annotations
     *
     * @param string $classname
     * @param array $classAnnotations
     */
    public function visit($classname, array $classAnnotations)
    {
        $this->result[$classname] = $classAnnotations;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}
