<?php
declare(strict_types=1);

namespace App\Tests\Detector;

use App\Detector\InterfaceDetector;

class InterfaceDetectorTest extends DetectorTestCase
{
    public function testDetectClassesListWithinFile()
    {
        $fileInfo = new \SplFileInfo($this->dataDir . '/list_of_classes.php');
        $interfaceDetector = new InterfaceDetector($fileInfo);
        $classesList = $interfaceDetector->extractList();

        $this->assertEquals($this->expectedInterfacesList(), $classesList);
    }

    private function expectedInterfacesList(): array
    {
        return [
            [
                'namespace' => 'Outside\Project',
                'name' => 'plainInterface'
            ],
            [
                'namespace' => 'Outside\Project',
                'name' => 'FancyInterface'
            ],
        ];
    }
}
