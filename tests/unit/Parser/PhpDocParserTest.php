<?php

namespace Butterfly\Component\Annotations\Tests\Parser;

use Butterfly\Component\Annotations\Parser\PhpDocParser;

class PhpDocParserTest extends \PHPUnit_Framework_TestCase
{
    public function getDataForTestParse()
    {
        return array(

            // case 1. annotation labels
            array('
                /**
                 * @annotation1
                 * @annotation2
                 */
                ',
                array(
                    'annotation1' => null,
                    'annotation2' => null,
                )
            ),

            // case 2. simple value
            array('
                /**
                 * @ann-bool-true true
                 * @ann-bool-false false
                 * @ann-int 123
                 * @ann-float 12.3
                 * @ann-string1 abc
                 * @ann-string2 123 abc
                 */
                ',
                array(
                    'ann-bool-true'  => true,
                    'ann-bool-false' => false,
                    'ann-int'        => 123,
                    'ann-float'      => 12.3,
                    'ann-string1'    => 'abc',
                    'ann-string2'    => '123 abc',
                )
            ),

            // case 3. indents
            array('
                /**
                 * @annotation1 123
                 * @annotation2       123
                 *      @annotation3  123
                 */
                ',
                array(
                    'annotation1' => 123,
                    'annotation2' => 123,
                    'annotation3' => 123,
                )
            ),

            // case 4. single-line phpDoc
            array('
                /** @annotation1 123 */
                ',
                array(
                    'annotation1' => 123,
                )
            ),

            // case 5. trash and line breaks
            array('
                /**
                 * name
                 *
                 * description description
                 * description description
                 *
                 * @annotation1 value1
                 * value2 value3
                 * @annotation2 123
                 * 456 789
                 *
                 * text text
                 * text
                 */
                ',
                array(
                    'annotation1' => 'value1 value2 value3',
                    'annotation2' => '123 456 789',
                )
            ),

            // case 6. json data
            array('
                /**
                 * @simple-array [1, 2, 3]
                 * @assoc-array {"key1": "value1", "key2": {"key21": "value21", "key22": [1, 2, 3]}}
                 * @multiline {
                 *      "key1": "value1"
                 * }
                 */
                ',
                array(
                    'simple-array' => array(1, 2, 3),
                    'assoc-array'  => array(
                        'key1' => 'value1',
                        'key2' => array(
                            'key21' => 'value21',
                            'key22' => array(1, 2, 3),
                        ),
                    ),
                    'multiline'    => array(
                        'key1' => 'value1'
                    ),
                )
            ),

            // case 7. dublicate annotations
            array('
                /**
                 * @param string $parameter1
                 * @param string $parameter2
                 * @param string $parameter3
                 *
                 * @json [1, 2, 3]
                 * @json {"key1": "value1", "key2": 123}
                 */
                ',
                array(
                    'param' => array(
                        'string $parameter1',
                        'string $parameter2',
                        'string $parameter3',
                    ),
                    'json' => array(
                        array(1, 2, 3),
                        array(
                            'key1' => 'value1',
                            'key2' => 123,
                        )
                    ),
                )
            ),
        );
    }

    /**
     * @dataProvider getDataForTestParse
     *
     * @param string $phpDoc
     * @param array $expectedResult
     */
    public function testParse($phpDoc, array $expectedResult)
    {
        $parser = new PhpDocParser();

        $annotations = $parser->parse($phpDoc);

        $this->assertEquals($expectedResult, $annotations);
    }
}
