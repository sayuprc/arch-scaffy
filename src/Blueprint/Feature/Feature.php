<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Feature;

final readonly class Feature
{
    /**
     * @param array<Scaffold> $scaffolds
     */
    public function __construct(
        public string $name,
        public array $scaffolds,
    ) {
    }
}
