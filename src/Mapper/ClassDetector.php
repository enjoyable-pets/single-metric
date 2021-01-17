<?php
declare(strict_types=1);

namespace App\Mapper;

class ClassDetector
{
    private array $classesList = [];
    private string $namespace;

    public function extractClassesList(\SplFileInfo $fileInfo): array
    {
        $fileContent = file_get_contents($fileInfo->getRealPath());

        $this->matchNamespace($fileContent);

        $this->matchClassCurlyLeft($fileContent);
        $this->matchClassImplements($fileContent);
        $this->matchClassExtends($fileContent);
        $this->matchInterfaceCurlyLeft($fileContent);
        $this->matchInterfaceExtends($fileContent);

        return $this->classesList;
    }

    private function matchNamespace(string $content)
    {
        preg_match("/namespace\s+[\w\\\\]+\s*;/", $content, $output);
        $this->trimNamespace($output);
    }

    private function matchClassCurlyLeft(string $content): void
    {
        preg_match_all("/class\s+[\w]+[\s]*\{/", $content, $output);
        $this->trimPatternOutput($output, 5, 1);
    }

    private function matchClassImplements(string $content): void
    {
        preg_match_all("/class\s+[\w]+[\s]+implements/", $content, $output);
        $this->trimPatternOutput($output, 5, 10);
    }

    private function matchClassExtends(string $content): void
    {
        preg_match_all("/class\s+[\w]+[\s]+extends/", $content, $output);
        $this->trimPatternOutput($output, 5, 8);
    }

    private function matchInterfaceCurlyLeft(string $content): void
    {
        preg_match_all("/interface\s+[\w]+[\s]*\{/", $content, $output);
        $this->trimPatternOutput($output, 9, 1);
    }

    private function matchInterfaceExtends(string $content): void
    {
        preg_match_all("/interface\s+[\w]+[\s]+extends/", $content, $output);
        $this->trimPatternOutput($output, 9, 8);
    }

    private function trimNamespace(array $patternOutput): void
    {
        $namespace = '';
        if (is_array($patternOutput) && count($patternOutput) > 0) {
            $namespace = $this->trimBeginEnd($patternOutput[0], 9, 1);
        }

        $this->namespace = $namespace;
    }

    private function trimPatternOutput(array $output, int $rmBegin, int $rmEnd)
    {
        foreach ($output as $pattern) {
            foreach ($pattern as $item) {
                $this->classesList[] = [
                    'namespace' => $this->namespace,
                    'name' => $this->trimBeginEnd($item, $rmBegin, $rmEnd)
                ];
            }
        }
    }

    private function trimBeginEnd($patternOutput, int $rmBegin, int $rmEnd): string
    {
        $temp = substr($patternOutput, $rmBegin);
        $temp = substr($temp, 0, -$rmEnd);

        return trim($temp);
    }
}
