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
        preg_match_all("/class\s+[\w]+[\s]*\{/", $this->fileContent, $output);
        $this->trimPatternOutput($output, 5, 1);
    }

    private function matchClassImplements(): void
    {
        preg_match_all("/class\s+[\w]+[\s]+implements/", $this->fileContent, $output);
        $this->trimPatternOutput($output, 5, 10);
    }

    private function matchClassExtends(): void
    {
        preg_match_all("/class\s+[\w]+[\s]+extends/", $this->fileContent, $output);
        $this->trimPatternOutput($output, 5, 8);
    }
}
