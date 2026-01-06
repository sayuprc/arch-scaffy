<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\RuleSet;

use ArchScaffy\Validator\Rule\RuleInterface;

final readonly class RuleSet
{
    /**
     * @param array<RuleInterface> $rules
     */
    public function __construct(
        public string $key,
        public array $rules,
    ) {
    }

    public function hasWildcard(): bool
    {
        return str_contains($this->key, '*');
    }
}
