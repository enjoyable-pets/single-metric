<?php
declare(strict_types=1);

namespace App\Tests\Detector;

use App\Detector\ClassDetector;

class ClassDetectorTest extends DetectorTestCase
{
    /**
     * @dataProvider detectClassesProvider
     * @param string $file
     * @param array $expected
     */
    public function testDetectAClassWithinFile(string $file, array $expected)
    {
        $fileInfo = new \SplFileInfo($this->dataDir . $file);
        $classDetector = new ClassDetector($fileInfo);
        $classesList = $classDetector->extractList();

        $this->assertEquals($expected, $classesList);
    }

    public function detectClassesProvider(): array
    {
        return [
            'AClass file' => ['/AClass.php', $this->expectedAClassList()],
            'list_of_classes file' => ['/list_of_classes.php', $this->expectedClassesList()],
        ];
    }

    private function expectedAClassList(): array
    {
        return [
            [
                'namespace' => 'Outside\Project',
                'name' => 'AClass'
            ]
        ];
    }

    private function expectedClassesList(): array
    {
        return [
            [
                'namespace' => 'Outside\Project',
                'name' => 'first'
            ],
            [
                'namespace' => 'Outside\Project',
                'name' => 'Second'
            ],
            [
                'namespace' => 'Outside\Project',
                'name' => 'simpleAbstract'
            ],
            [
                'namespace' => 'Outside\Project',
                'name' => 'abstractMain'
            ],
            [
                'namespace' => 'Outside\Project',
                'name' => 'inherited'
            ],
            [
                'namespace' => 'Outside\Project',
                'name' => 'Third'
            ],
        ];
    }
}
