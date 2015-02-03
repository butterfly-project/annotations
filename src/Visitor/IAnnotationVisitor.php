<?php

namespace Butterfly\Component\Annotations\Visitor;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
interface IAnnotationVisitor
{
    /**
     * Clean visitor
     */
    public function clean();

    /**
     * Visit one class annotations
     *
     * @param string $classname
     * @param array $classAnnotations
     */
    public function visit($classname, array $classAnnotations);
}
