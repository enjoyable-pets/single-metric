<?php
declare(strict_types=1);

namespace App\Tests\Mapper;

use App\Mapper\ClassMapper;
use App\Mapper\PhpFilesMapper;
use PHPUnit\Framework\TestCase;

class ClassMapperTest extends TestCase
{
    private string $dataDir;

    public function testClassesMapping()
    {
        $filesMapper = new PhpFilesMapper($this->dataDir);
        $classMapper = new ClassMapper($filesMapper);

        $this->assertEquals([], $classMapper->getMapping());
    }

    protected function setUp(): void
    {
        $this->dataDir = realpath(__DIR__ . '/../data');
    }
}
