<?php

namespace Butterfly\Component\Annotations\FileLoader;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
interface IFileLoader
{
    /**
     * @param string $dir
     */
    public function loadFilesFromDir($dir);
}
