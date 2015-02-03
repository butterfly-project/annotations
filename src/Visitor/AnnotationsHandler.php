<?php

namespace Butterfly\Component\Annotations\Visitor;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class AnnotationsHandler
{
    /**
     * @var IAnnotationVisitor[]
     */
    protected $visitors;

    /**
     * @param IAnnotationVisitor[] $visitors
     */
    public function __construct(array $visitors = array())
    {
        foreach ($visitors as $visitor) {
            $this->addVisitor($visitor);
        }
    }

    /**
     * @param IAnnotationVisitor $visitor
     */
    public function addVisitor(IAnnotationVisitor $visitor)
    {
        $this->visitors[] = $visitor;
    }

    /**
     * @param array $annotations
     */
    public function handle(array $annotations)
    {
        $this->cleanVisitors();

        foreach ($annotations as $className => $classAnnotations) {
            foreach ($this->visitors as $visitor) {
                $visitor->visit($className, $classAnnotations);
            }
        }
    }

    protected function cleanVisitors()
    {
        foreach ($this->visitors as $visitor) {
            $visitor->clean();
        }
    }
}
