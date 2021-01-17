<?php
declare(strict_types=1);

namespace App\Detector;

class InterfaceDetector extends AbstractDetector
{
    public function extractList(): array
    {
        $this->matchInterfaceCurlyLeft();
        $this->matchInterfaceExtends();

        return $this->getList();
    }

    private function matchInterfaceCurlyLeft(): void
    {
        preg_match_all("/interface\s+[\w]+[\s]*\{/", $this->fileContent, $output);
        $this->trimPatternOutput($output, 9, 1);
    }

    private function matchInterfaceExtends(): void
    {
        preg_match_all("/interface\s+[\w]+[\s]+extends/", $this->fileContent, $output);
        $this->trimPatternOutput($output, 9, 8);
    }
}
