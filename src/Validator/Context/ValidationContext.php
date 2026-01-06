<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Context;

use Generator;

final readonly class ValidationContext implements ValidationContextInterface
{
    /**
     * @param array<mixed> $data
     */
    public function __construct(private array $data)
    {
    }

    public function get(int|string $key): mixed
    {
        return array_reduce(
            $this->explodeKey($key),
            fn (mixed $carry, string $segment): mixed => is_array($carry) && array_key_exists($segment, $carry)
                ? $carry[$segment]
                : null,
            $this->data
        );
    }

    public function has(int|string $key): bool
    {
        return ! is_null(
            array_reduce(
                $this->explodeKey($key),
                fn (mixed $carry, string $segment) => is_array($carry) && array_key_exists($segment, $carry)
                    ? $carry[$segment]
                    : null,
                $this->data,
            )
        );
    }

    /**
     * @return Generator<string, mixed>
     */
    public function resolveWildcard(int|string $key): Generator
    {
        yield from $this->resolveRecursive($this->explodeKey($key), $this->data, []);
    }

    /**
     * @param array<string>     $segments
     * @param array<string|int> $keys
     *
     * @return Generator<string, mixed>
     */
    private function resolveRecursive(array $segments, mixed $currentValue, array $keys): Generator
    {
        if (count($segments) === 0) {
            yield implode('.', $keys) => $currentValue;

            return;
        }

        $segment = array_shift($segments);

        if ($segment === '*') {
            if (! is_array($currentValue)) {
                return;
            }

            foreach ($currentValue as $key => $value) {
                yield from $this->resolveRecursive($segments, $value, [...$keys, (string)$key]);
            }
        }

        if (! is_array($currentValue) || ! array_key_exists($segment, $currentValue)) {
            return;
        }

        yield from $this->resolveRecursive($segments, $currentValue[$segment], [...$keys, $segment]);
    }

    public function getScope(int|string $baseKey, int|string $referenceKey): self
    {
        $baseSegments = $this->explodeKey($baseKey);
        $referenceSegments = $this->explodeKey($referenceKey);

        $count = max(count($baseSegments), count($referenceSegments));
        $segments = [];
        for ($i = 0; $i < $count; $i++) {
            $baseValue = $baseSegments[$i] ?? null;
            $referenceValue = $referenceSegments[$i] ?? null;

            if (is_null($baseValue) || is_null($referenceValue)) {
                break;
            }

            if ($baseValue === $referenceValue) {
                $segments[] = $baseValue;
            } elseif ($baseValue === '*' && $referenceValue !== '*') {
                $segments[] = $referenceValue;
            } elseif ($baseValue !== '*' && $referenceValue === '*') {
                $segments[] = $baseValue;
            }
        }

        $newKey = implode('.', $segments);

        $item = $this->get($newKey);

        if (! is_array($item)) {
            $item = [$newKey => $item];
        }

        return new ValidationContext($item);
    }

    /**
     * @return array<string>
     */
    private function explodeKey(int|string $key): array
    {
        return explode('.', (string)$key);
    }
}
