<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature\Component;

final readonly class InterfaceComponent implements ComponentInterface
{
    /**
     * @param array<string, string> $placeholders
     */
    public function __construct(
        public string $name,
        public string $layer,
        public array $placeholders = [],
    ) {
    }
}
