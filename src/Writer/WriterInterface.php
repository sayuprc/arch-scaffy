<?php

declare(strict_types=1);

namespace ArchScaffy\Writer;

interface WriterInterface
{
    public function write(string $content, string $destination): void;
}
