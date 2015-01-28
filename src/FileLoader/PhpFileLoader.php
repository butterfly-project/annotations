<?php

namespace Butterfly\Component\Annotations\FileLoader;

class PhpFileLoader implements IFileLoader
{
    /**
     * @param string $dirPath
     */
    public function loadDirectory($dirPath)
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
    public function loadFile($filePath)
    {
        require_once $filePath;
    }

}
