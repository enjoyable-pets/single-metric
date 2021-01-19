<?php
declare(strict_types=1);

namespace App\Detector;

abstract class AbstractDetector
{
    protected string $fileContent = '';
    private string $namespace = '';
    private array $list = [];
    private \SplFileInfo $fileInfo;

    public function __construct(\SplFileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
        $this->setup($fileInfo);
    }

    abstract public function extractList(): array;

    protected function getList(): array
    {
        return $this->list;
    }

    protected function addToList(array $item)
    {
        $this->list[] = $item;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    protected function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    protected function matchNamespace(string $content)
    {
        preg_match("/namespace\s+[\w\\\\]+\s*;/", $content, $output);
        $this->trimNamespace($output);
    }

    private function trimNamespace(array $patternOutput): void
    {
        if (is_array($patternOutput) && count($patternOutput) > 0) {
            $this->namespace = $this->trimBeginEnd($patternOutput[0], 9, 1);
        }
    }

    protected function addPregOutputToList(string $pattern)
    {
        preg_match_all($pattern, $this->fileContent, $output);
        if (!array_key_exists(1, $output)) {
            return;
        }
        foreach ($output[1] as $value) {
            $item = [
                'namespace' => $this->getNamespace(),
                'name' => $value
            ];

            $this->addToList($item);
        }
    }

    protected function trimPatternOutput(array $output, int $rmBegin, int $rmEnd)
    {
        foreach ($output as $pattern) {
            foreach ($pattern as $item) {
                $item = [
                    'namespace' => $this->getNamespace(),
                    'name' => $this->trimBeginEnd($item, $rmBegin, $rmEnd)
                ];

                $this->addToList($item);
            }
        }
    }

    protected function trimBeginEnd($patternOutput, int $rmBegin, int $rmEnd): string
    {
        $temp = substr($patternOutput, $rmBegin);
        if ($rmEnd > 0) {
            $temp = substr($temp, 0, -$rmEnd);
        }

        return trim($temp);
    }

    private function setup(\SplFileInfo $fileInfo): void
    {
        $this->fileContent = file_get_contents($fileInfo->getRealPath());
        $this->matchNamespace($this->fileContent);
    }
}
