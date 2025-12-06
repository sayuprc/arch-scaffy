<?php

declare(strict_types=1);

namespace ArchScaffy\YamlParser;

interface YamlParserInterface
{
    /**
     * @return array<mixed>
     */
    public function parseFile(string $file): array;
}
