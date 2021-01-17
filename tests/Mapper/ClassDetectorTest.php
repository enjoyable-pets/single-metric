<?php
declare(strict_types=1);

namespace App\Tests\Mapper;

use App\Mapper\ClassDetector;
use PHPUnit\Framework\TestCase;

class ClassDetectorTest extends TestCase
{
    private string $dataDir;

    public function testDetectAClassWithinFile()
    {
        $fileInfo = new \SplFileInfo($this->dataDir . '/AClass.php');
        $classDetector = new ClassDetector();
        $classesList = $classDetector->extractClassesList($fileInfo);

        $this->assertEquals($this->expectedAClassList(), $classesList);
    }

    public function testDetectClassesListWithinFile()
    {
        $fileInfo = new \SplFileInfo($this->dataDir . '/list_of_classes.php');
        $classDetector = new ClassDetector();
        $classesList = $classDetector->extractClassesList($fileInfo);

        $this->assertEquals($this->expectedClassesList(), $classesList);
    }

    private function expectedAClassList(): array
    {
        return [
            [
                'namespace' => 'App\Tests\data',
                'name' => 'AClass'
            ]
        ];
    }

    private function expectedClassesList(): array
    {
        return [
            [
                'namespace' => 'App\Tests\data',
                'name' => 'first'
            ],
            [
                'namespace' => 'App\Tests\data',
                'name' => 'Second'
            ],
            [
                'namespace' => 'App\Tests\data',
                'name' => 'simpleAbstract'
            ],
            [
                'namespace' => 'App\Tests\data',
                'name' => 'abstractMain'
            ],
            [
                'namespace' => 'App\Tests\data',
                'name' => 'inherited'
            ],
            [
                'namespace' => 'App\Tests\data',
                'name' => 'Third'
            ],
            [
                'namespace' => 'App\Tests\data',
                'name' => 'plainInterface'
            ],
            [
                'namespace' => 'App\Tests\data',
                'name' => 'FancyInterface'
            ],
        ];
    }

    protected function setUp(): void
    {
        $this->dataDir = realpath(__DIR__ . '/../data');
    }
}
