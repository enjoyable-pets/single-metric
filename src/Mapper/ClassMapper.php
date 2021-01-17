<?php
declare(strict_types=1);

namespace App\Mapper;

class ClassMapper
{
    private PhpFilesMapper $filesMapper;
    private array $mapping = [];

    public function __construct(PhpFilesMapper $filesMapper)
    {
        $this->filesMapper = $filesMapper;
    }

    public function getMapping(): array
    {
        return $this->mapping;
    }
}
