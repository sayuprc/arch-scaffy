<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule\Type;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\ContinuableRule;
use Override;

final readonly class StringRule extends TypeRule
{
    use ContinuableRule;

    #[Override]
    public function validate(mixed $value, int|string $key, ValidationContextInterface $context): array
    {
        if (! is_string($value)) {
            return [$this->formatMessage($value, $key, 'string')];
        }

        return [];
    }
}
