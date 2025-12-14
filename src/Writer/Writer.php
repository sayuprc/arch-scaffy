<?php

declare(strict_types=1);

namespace ArchScaffy\Writer;

use Override;

final readonly class Writer implements WriterInterface
{
    #[Override]
    public function write(string $content, string $destination): void
    {
        file_put_contents($destination, $content);
    }
}
