<?php
declare(strict_types=1);

namespace App\Tests\FilesLoader;

use App\FilesLoader\FilesLoader;
use App\Mapper\PhpFilesMapper;
use PHPUnit\Framework\TestCase;

class FilesLoaderTest extends TestCase
{
    private string $outsideDir;

    public function testFilesLoader()
    {
        $this->assertFalse($this->isClassFirstDeclared());

        $filesMapper = new PhpFilesMapper($this->outsideDir);
        $filesLoader = new FilesLoader();
        $filesLoader->registerFiles($filesMapper);

        $this->assertTrue($this->isClassFirstDeclared());
        $this->assertClassesDeclared();
        $this->assertInterfacesDeclared();
    }

    protected function setUp(): void
    {
        $this->outsideDir = realpath(__DIR__ . '/../data/outside');
    }

    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    private function isClassFirstDeclared(): bool
    {
        return in_array('Outside\Project\first', get_declared_classes());
    }

    private function assertClassesDeclared()
    {
        $declaredClasses = get_declared_classes();

        $this->assertTrue(in_array('Outside\Project\Second', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\abstractMain', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\simpleAbstract', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\inherited', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\Third', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\AClass', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\BClass', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\APackage\AaClass', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\APackage\AbClass', $declaredClasses));
        $this->assertTrue(in_array('Outside\Project\Logger\SimpleLogger', $declaredClasses));
    }

    private function assertInterfacesDeclared()
    {
        $declaredInterfaces = get_declared_interfaces();

        $this->assertTrue(in_array('Outside\Project\plainInterface', $declaredInterfaces));
        $this->assertTrue(in_array('Outside\Project\FancyInterface', $declaredInterfaces));
    }
}