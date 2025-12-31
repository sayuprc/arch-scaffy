<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Class;

use ArchScaffy\Ast\Builder\AstComponentBuilderInterface;
use ArchScaffy\Ir\ComponentIrInterface;

final readonly class InterfaceIr implements ComponentIrInterface
{
    public function __construct(public string $name)
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function accept(AstComponentBuilderInterface $builder)
    {
        return $builder->buildInterface($this);
    }
}
