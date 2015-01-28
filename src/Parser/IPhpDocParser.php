<?php

namespace Butterfly\Component\Annotations\Parser;

interface IPhpDocParser
{
    /**
     * @param string $phpDoc
     * @return array
     */
    public function parse($phpDoc);
}
