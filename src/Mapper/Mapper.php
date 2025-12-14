<?php

declare(strict_types=1);

namespace ArchScaffy\Mapper;

use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use Override;

readonly class Mapper implements MapperInterface
{
    public function __construct(private MapperBuilder $builder)
    {
    }

    #[Override]
    public function map(string $signature, array $source): mixed
    {
        return $this->builder
            ->mapper()
            ->map($signature, Source::array($source));
    }
}
