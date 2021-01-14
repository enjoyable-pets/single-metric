<?php
declare(strict_types=1);

namespace App\Tests\FilesFinder;

use App\FilesFinder\Finder;
use PHPUnit\Framework\TestCase;

class FinderTest extends TestCase
{
    public function testFindFiles()
    {
        $finder = new Finder();
        $result = $finder->find();

        $this->assertTrue($result);
    }
}
