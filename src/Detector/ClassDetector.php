<?php
declare(strict_types=1);

namespace App\Detector;

class ClassDetector extends AbstractDetector
{
    public function extractList(): array
    {
        $this->matchClassCurlyLeft();
        $this->matchClassImplements();
        $this->matchClassExtends();

        return $this->getList();
    }

    private function matchClassCurlyLeft(): void
    {
        $this->addPregOutputToList("/class\s+(\w+)\s*\{/");
    }

    private function matchClassImplements(): void
    {
        $this->addPregOutputToList("/class\s+(\w+)\s+implements/");
    }

    private function matchClassExtends(): void
    {
        $this->addPregOutputToList("/class\s+(\w+)\s+extends/");
    }
}
