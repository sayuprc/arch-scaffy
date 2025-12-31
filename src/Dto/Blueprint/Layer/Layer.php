<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Layer;

final readonly class Layer
{
    public function __construct(
        public string $output,
        public string $namespace,
    ) {
    }
}
