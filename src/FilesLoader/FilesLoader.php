<?php
declare(strict_types=1);

namespace App\FilesLoader;

use App\Mapper\PhpFilesMapper;

class FilesLoader
{
    public function registerFiles(PhpFilesMapper $filesMapper)
    {
        foreach ($filesMapper->getFilesPaths() as $file) {
            try {
                $this->loadFile($file);
            } catch (\Throwable $exception) {
            }
        }
//        $this->register();
    }

    public function register()
    {
        spl_autoload_register([$this, 'loadFile'], true, true);
    }

    public function unregister()
    {
        spl_autoload_unregister([$this, 'loadFile']);
    }

    public function loadFile($filePath)
    {
        $this->includeFile($filePath);
    }

    function includeFile($file)
    {
        include $file;
    }
}
