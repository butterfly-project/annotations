<?php

namespace Butterfly\Component\Annotations\FileLoader;

interface IFileLoader
{
    /**
     * @param string $dir
     */
    public function loadFilesFromDir($dir);
}
