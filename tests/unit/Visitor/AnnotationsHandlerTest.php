<?php

namespace Butterfly\Component\Annotations\Tests;

use Butterfly\Component\Annotations\Tests\Visitor\Stub\SimpleVisitor;
use Butterfly\Component\Annotations\Visitor\AnnotationsHandler;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class AnnotationsHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandle()
    {
        $annotations = array(
            'Class1' => array('annotation_1_1', 'annotation_1_2', 'annotation_1_3'),
            'Class2' => array('annotation_2_1', 'annotation_2_2', 'annotation_2_3'),
            'Class3' => array('annotation_3_1', 'annotation_3_2', 'annotation_3_3'),
        );

        $visitor = new SimpleVisitor();
        $handler = new AnnotationsHandler(array($visitor));

        $handler->handle($annotations);
        $result = $visitor->getResult();

        $this->assertEquals($annotations, $result);
    }
}
