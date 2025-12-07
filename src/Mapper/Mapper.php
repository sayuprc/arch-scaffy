<?php

declare(strict_types=1);

namespace ArchScaffy\Mapper;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;

readonly class Mapper implements MapperInterface
{
    public function __construct(private MapperBuilder $builder)
    {
    }

    public function map(string $signature, array $source): mixed
    {
        return $this->builder
            ->mapper()
            ->map($signature, Source::array($source));
    }
}
