<?php

namespace Butterfly\Component\Annotations\FileLoader;

/**
 * @author Marat Fakhertdinov <marat.fakhertdinov@gmail.com>
 */
class FileLoader implements IFileLoader
{
    /**
     * @param string $dirPath
     */
    public function loadFilesFromDir($dirPath)
    {
        $filePaths = $this->getFilesFromDir(realpath($dirPath));

        foreach ($filePaths as $filePath) {
            $this->loadFile($filePath);
        }
    }

    /**
     * @param string $path
     * @return array
     */
    protected function getFilesFromDir($path)
    {
        $iterator = new \DirectoryIterator($path);

        $files = array();

        foreach ($iterator as $item) {
            if($item->isDot()) {
                continue;
            }

            if ($item->isDir()) {
                $files = array_merge($files, $this->getFilesFromDir($item->getRealPath()));
            } elseif ($item->isFile()) {
                $files[] = $item->getRealPath();
            }
        }

        return $files;
    }

    /**
     * @param string $filePath
     */
    protected function loadFile($filePath)
    {
        require_once $filePath;
    }
}
