<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use Override;

final readonly class RequiredRule implements RuleInterface
{
    use AbortableRule;

    #[Override]
    public function validate(mixed $value, int|string $key, ValidationContextInterface $context): array
    {
        if (! $context->has($key)) {
            return [sprintf('Missing required key: "%s".', $key)];
        }

        return [];
    }
}
