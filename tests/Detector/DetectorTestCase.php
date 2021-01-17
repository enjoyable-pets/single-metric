<?php
declare(strict_types=1);

namespace App\Tests\Detector;

use PHPUnit\Framework\TestCase;

class DetectorTestCase extends TestCase
{
    protected string $dataDir;

    protected function setUp(): void
    {
        $this->dataDir = realpath(__DIR__ . '/../data/outside');
    }
}
