<?php

declare(strict_types=1);

namespace ArchScaffy\Parser;

interface ParserInterface
{
    /**
     * @return array<mixed>
     */
    public function parseFile(string $file): array;
}
