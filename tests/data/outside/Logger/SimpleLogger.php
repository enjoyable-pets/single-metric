<?php
declare(strict_types=1);

namespace Outside\Project\Logger;

use Outside\Project\BClass;
use Outside\Project\AClass;
use Psr\Log\LoggerInterface;
use Outside\Project AS OutsideProject;

class SimpleLogger
{
    private string $simpleProperty = 'simple';
    private LoggerInterface $logger;
    private $aClass;
    private $bClass;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->aClass = new AClass();
        $this->bClass = new BClass();
    }

    public function logData(string $message)
    {
        $this->logger->info($message);
    }

    public function createAa()
    {
        return new OutsideProject\APackage\AaClass();
    }
}
