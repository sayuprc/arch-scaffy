<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule\Array;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\ContinuableRule;
use ArchScaffy\Validator\Rule\RuleInterface;
use Override;

final readonly class ArrayKeyIsStringRule implements RuleInterface
{
    use ContinuableRule;

    /**
     * @param array<mixed> $value
     */
    #[Override]
    public function validate(mixed $value, int|string $key, ValidationContextInterface $context): array
    {
        $errors = [];

        foreach (array_keys($value) as $arrayKey) {
            if (! is_string($arrayKey)) {
                $errors[] = sprintf('Array key "%s" must be a string, %s given.', $arrayKey, get_debug_type($arrayKey));
            }
        }

        return $errors;
    }
}
