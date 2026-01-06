<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule;

use ArchScaffy\Validator\Context\ValidationContextInterface;

interface RuleInterface
{
    /**
     * @return array<string>
     */
    public function validate(mixed $value, int|string $key, ValidationContextInterface $context): array;

    public function failurePolicy(): FailurePolicy;
}
