<?php
declare(strict_types=1);

namespace App\FilesMapper;

class PhpFilesMapper
{
    private string $dir;
    private array $filesMap = [];

    public function __construct(string $dir)
    {
        $this->dir = $dir;
        $this->createMap();
    }

    public function getFilesMap(): array
    {
        return $this->filesMap;
    }

    private function createMap()
    {
        foreach ($this->createFilesIterator() as $fileInfo) {
            $this->addToMapPhpFile($fileInfo);
        }
    }

    private function createFilesIterator(): \Iterator
    {
        $directory = new \RecursiveDirectoryIterator($this->dir);

        return new \RecursiveIteratorIterator($directory);
    }

    private function addToMapPhpFile(\SplFileInfo $fileObject): void
    {
        if ('php' === $fileObject->getExtension()) {
            $this->filesMap[$fileObject->getPathname()] = $fileObject;
        }
    }
}
