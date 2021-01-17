<?php
declare(strict_types=1);

namespace App\Detector;

class UseDetector extends AbstractDetector
{
    public function extractList(): array
    {
        $this->matchUseSemicolon();

        return $this->getList();
    }

    private function matchUseSemicolon(): void
    {
        preg_match_all("/use\s+[\w\\\\]+[\s]*;/", $this->fileContent, $output);
        $this->trimUseOutput($output);
    }

    protected function trimUseOutput(array $output)
    {
        foreach ($output as $pattern) {
            foreach ($pattern as $item) {
                $path = $this->trimBeginEnd($item, 3, 1);
                $parts = explode('\\', $path);
                $lastIndex = count($parts)-1;
                $name = $parts[$lastIndex];
                unset($parts[$lastIndex]);
                $namespace = implode('\\', $parts);

                $item = [
                    'namespace' => $namespace,
                    'name' => $name
                ];

                $this->addToList($item);
            }
        }
    }
}
