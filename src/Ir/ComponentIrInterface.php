<?php

declare(strict_types=1);

namespace ArchScaffy\Ir;

use ArchScaffy\Ast\Builder\AstComponentBuilderInterface;

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
