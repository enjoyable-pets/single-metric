<?php
declare(strict_types=1);

namespace App\Detector;

class UseDetector extends AbstractDetector
{
    public function extractList(): array
    {
        $this->matchUse();
        $this->matchUseAs();

        return $this->getList();
    }

    private function matchUse(): void
    {
        preg_match_all("/use\s+[\w\\\\]+[\s]*;/i", $this->fileContent, $output);
        $this->trimUseOutput($output);
    }

    private function trimUseOutput(array $output)
    {
        foreach ($output as $pattern) {
            foreach ($pattern as $item) {
                $path = $this->trimBeginEnd($item, 3, 1);
                [$namespace, $name] = $this->splitNamespaceAndName($path);

                $item = [
                    'namespace' => $namespace,
                    'name' => $name
                ];

                $this->addToList($item);
            }
        }
    }

    private function splitNamespaceAndName(string $path): array
    {
        $parts = explode('\\', $path);
        $lastIndex = count($parts)-1;
        $name = $parts[$lastIndex];
        unset($parts[$lastIndex]);
        $namespace = implode('\\', $parts);

        return [$namespace, $name];
    }

    private function matchUseAs(): void
    {
        preg_match_all("/use\s+\w+[\\\\\w]*\s+as\s+\w+\s*;/i", $this->fileContent, $mainOutput);
        foreach ($mainOutput as $pattern) {
            foreach ($pattern as $item) {
                $found = preg_match("/\s+as\s/i", $item, $delimiterOutput);
                if ($found) {
                    $delimiter = $delimiterOutput[0];
                    [$rawNamespace, $rawAlias] = explode($delimiter, $item);
                    $namespaceBegin = $this->trimBeginEnd($rawNamespace, 3, 0);


                    $alias = $this->trimBeginEnd($rawAlias, 0, 1);
                    $createObjectPattern = '/new\s+'.$alias.'[\\\\\w]*\(\)/';
                    $isCreateObjectFound = preg_match($createObjectPattern, $this->fileContent, $createObjectOutput);
                    if ($isCreateObjectFound) {
                        [$partNew, $partClassName] = explode($alias, $createObjectOutput[0]);
                        $trailingClassName = $this->trimBeginEnd($partClassName, 0, 2);
                        $fullNamespace = $namespaceBegin . $trailingClassName;

                        [$namespace, $name] = $this->splitNamespaceAndName($fullNamespace);

                        $item = [
                            'namespace' => $namespace,
                            'name' => $name
                        ];

                        $this->addToList($item);
                    }
                }
            }
        }

    }
}
