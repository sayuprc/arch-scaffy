<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use BackedEnum;
use Override;

final readonly class ForbiddenIfValueRule implements RuleInterface
{
    use AbortableRule;

    private bool $isSameScope;

    public function __construct(
        private string $referenceKey,
        private BackedEnum|bool|float|int|string $referenceValue,
    ) {
        $this->isSameScope = str_contains($this->referenceKey, '*');
    }

    #[Override]
    public function validate(mixed $value, int|string $key, ValidationContextInterface $context): array
    {
        $scope = $context->getScope($key, $this->referenceKey);

        if ($scope->get($this->searchKey()) === $this->getOtherValue() && $context->has($key)) {
            return [
                sprintf(
                    'The field "%s" must not be present when "%s" is %s.',
                    $key,
                    $this->searchKey(),
                    match(true) {
                        is_bool($this->getOtherValue()) => var_export($this->getOtherValue(), true),
                        default => $this->getOtherValue()
                    }
                ),
            ];
        }

        return [];
    }

    private function searchKey(): string
    {
        if (! $this->isSameScope) {
            return $this->referenceKey;
        }

        $segments = explode('.', $this->referenceKey);

        return array_pop($segments);
    }

    private function getOtherValue(): bool|float|int|string
    {
        if ($this->referenceValue instanceof BackedEnum) {
            return $this->referenceValue->value;
        }

        return $this->referenceValue;
    }
}
