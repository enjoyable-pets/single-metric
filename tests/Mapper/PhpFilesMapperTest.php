<?php
declare(strict_types=1);

namespace App\Tests\Mapper;

use App\Mapper\PhpFilesMapper;
use PHPUnit\Framework\TestCase;

class PhpFilesMapperTest extends TestCase
{
    private string $dataDir;

    public function testCreateMap()
    {
        $filesMapper = new PhpFilesMapper($this->dataDir);

        $this->assertEquals($this->expectedFilesList(), $filesMapper->getFilesMap());
    }

    protected function setUp(): void
    {
        $this->dataDir = realpath(__DIR__ . '/../data/outside');
    }

    private function expectedFilesList(): array
    {
        $A = new \SplFileInfo($this->dataDir.'/AClass.php');
        $B = new \SplFileInfo($this->dataDir.'/BClass.php');
        $Aa = new \SplFileInfo($this->dataDir.'/APackage/AaClass.php');
        $Ab = new \SplFileInfo($this->dataDir.'/APackage/AbClass.php');
        $listOfClasses = new \SplFileInfo($this->dataDir.'/list_of_classes.php');
        $simpleLogger = new \SplFileInfo($this->dataDir.'/Logger/SimpleLogger.php');

        return [
            $A->getPathname() => $A,
            $B->getPathname() => $B,
            $Ab->getPathname() => $Ab,
            $Aa->getPathname() => $Aa,
            $listOfClasses->getPathname() => $listOfClasses,
            $simpleLogger->getPathname() => $simpleLogger,
        ];
    }
}
