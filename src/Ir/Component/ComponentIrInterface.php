<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Component;

use ArchScaffy\Ast\AstComponentBuilderInterface;

interface ComponentIrInterface
{
    public function name(): string;

    /**
     * @template T
     *
     * @param AstComponentBuilderInterface<T> $builder
     *
     * @return T
     */
    public function accept(AstComponentBuilderInterface $builder);
}
