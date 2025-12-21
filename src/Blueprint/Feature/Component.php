<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature;

final readonly class Component
{
    /**
     * @param array<string, string> $placeholders
     */
    public function __construct(
        public string $name,
        public string $layer,
        public Kind $kind,
        public array $placeholders = [],
        public ?bool $final = null,
        public ?bool $readonly = null,
        public bool $abstract = false,
    ) {
    }
}
