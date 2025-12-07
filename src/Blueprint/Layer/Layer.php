<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Layer;

final readonly class Layer
{
    public function __construct(
        public string $output,
        public string $namespace,
    ) {
    }
}
