<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Context;

use Generator;

interface ValidationContextInterface
{
    public function get(int|string $key): mixed;

    public function has(int|string $key): bool;

    /**
     * @return Generator<string, mixed>
     */
    public function resolveWildcard(int|string $key): Generator;

    public function getScope(int|string $baseKey, int|string $referenceKey): self;
}
