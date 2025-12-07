<?php

declare(strict_types=1);

namespace ArchScaffy\Mapper;

interface MapperInterface
{
    /**
     * @template T of object
     *
     * @param string|class-string<T> $signature
     * @param array<mixed>           $source
     *
     * @return T
     *
     * @phpstan-return (
     *     $signature is class-string<T>
     *         ? T
     *         : ($signature is class-string ? object : mixed)
     * )
     */
    public function map(string $signature, array $source): mixed;
}
