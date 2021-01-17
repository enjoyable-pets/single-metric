<?php
declare(strict_types=1);

namespace App\Tests\Detector;

use App\Detector\UseDetector;

class UseDetectorTest  extends DetectorTestCase
{
    public function testListOfUses()
    {
        $fileInfo = new \SplFileInfo($this->dataDir . '/Logger/SimpleLogger.php');
        $useDetector = new UseDetector($fileInfo);
        $classesList = $useDetector->extractList();

        $this->assertEquals($this->expectedDependencies(), $classesList);
    }

    private function expectedDependencies(): array
    {
        return [
            [
                'namespace' => 'Outside\Project',
                'name' => 'BClass'
            ],
            [
                'namespace' => 'Outside\Project',
                'name' => 'AClass'
            ],
            [
                'namespace' => 'Psr\Log',
                'name' => 'LoggerInterface'
            ],
        ];
    }
}
