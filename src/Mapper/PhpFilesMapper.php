<?php
declare(strict_types=1);

namespace App\Mapper;

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

    public function getFilesPaths(): array
    {
        return array_keys($this->filesMap);
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

    private function addToMapPhpFile(\SplFileInfo $splFileInfo): void
    {
        if ($this->isInVendor($splFileInfo)) {
            return;
        }

        if ('php' === $splFileInfo->getExtension()) {
            $this->filesMap[$splFileInfo->getPathname()] = $splFileInfo;
        }
    }

    private function isInVendor(\SplFileInfo $splFileInfo): bool
    {
        $filePath = $splFileInfo->getRealPath();
        preg_match("/\/vendor\//", $filePath, $output);

        return count($output) > 0;
    }
}
