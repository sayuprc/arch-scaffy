<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule\Array;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\ContinuableRule;
use ArchScaffy\Validator\Rule\RuleInterface;
use Override;

final readonly class ArrayHasKeyRule implements RuleInterface
{
    use ContinuableRule;

    private bool $isSameScope;

    public function __construct(private string $referenceKey)
    {
        $this->isSameScope = str_contains($this->referenceKey, '*');
    }

    /**
     * @param string|int|float|bool $value
     */
    #[Override]
    public function validate(mixed $value, int|string $key, ValidationContextInterface $context): array
    {
        $scope = $this->isSameScope
            ? $context->getScope($key, $this->referenceKey)
            : $context;

        $item = $scope->get($this->searchKey());

        if (! is_array($item)) {
            return [sprintf('The value for "%s" must be an array, %s given.', $this->referenceKey, get_debug_type($item))];
        }

        foreach (array_keys($item) as $referenceKey) {
            if ($referenceKey === $value) {
                return [];
            }
        }

        return [sprintf('Missing required key "%s" in the array.', $value)];
    }

    private function searchKey(): string
    {
        if (! $this->isSameScope) {
            return $this->referenceKey;
        }

        $segments = explode('.', $this->referenceKey);

        return array_pop($segments);
    }
}
