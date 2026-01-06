<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use BackedEnum;
use Override;

final readonly class InRule implements RuleInterface
{
    use ContinuableRule;

    /**
     * @param array<mixed> $haystack
     */
    public function __construct(private array $haystack)
    {
    }

    /**
     * @param string|int|float $value
     */
    #[Override]
    public function validate(mixed $value, int|string $key, ValidationContextInterface $context): array
    {
        if (! in_array($value, $this->getHaystack(), true)) {
            return [sprintf('The value "%s" is not one of the allowed values.', $value)];
        }

        return [];
    }

    /**
     * @return array<mixed>
     */
    private function getHaystack(): array
    {
        return array_map(
            fn (mixed $item): mixed => $item instanceof BackedEnum
                ? $item->value
                : $item,
            $this->haystack
        );
    }
}
