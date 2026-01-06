<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule\Type;

use ArchScaffy\Validator\Rule\RuleInterface;

abstract readonly class TypeRule implements RuleInterface
{
    /**
     * @param 'string'|'array'|'int'|'float'|'bool' $expectedType
     */
    protected function formatMessage(mixed $value, int|string $key, string $expectedType): string
    {
        return sprintf(
            'The value of "%s" must be a %s, %s given.',
            $key,
            $expectedType,
            get_debug_type($value)
        );
    }
}
