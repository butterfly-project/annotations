<?php

namespace Butterfly\Tests;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class ServicesTest extends BaseDiTest
{
    public function getDataForTestService()
    {
        return array(
            array('bfy.annotations.php_doc_parser'),
            array('bfy.annotations.file_loader'),
            array('bfy.annotations.class_parser'),
        );
    }

    /**
     * @dataProvider getDataForTestService
     * @param string $serviceName
     */
    public function testService($serviceName)
    {
        self::$container->get($serviceName);
    }
}
