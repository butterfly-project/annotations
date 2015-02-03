<?php

namespace Butterfly\Component\Annotations\Parser;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
interface IPhpDocParser
{
    /**
     * @param string $phpDoc
     * @return array
     */
    public function parse($phpDoc);
}
