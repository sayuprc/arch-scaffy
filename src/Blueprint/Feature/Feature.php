<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature;

final readonly class Feature
{
    /**
     * @param array<Component> $components
     */
    public function __construct(
        public string $name,
        public array $components,
    ) {
    }
}
