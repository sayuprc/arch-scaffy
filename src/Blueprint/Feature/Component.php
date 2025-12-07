<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Feature;

final readonly class Component
{
    public function __construct(
        public string $name,
        public string $layer,
        public Kind $kind,
    ) {
    }
}
