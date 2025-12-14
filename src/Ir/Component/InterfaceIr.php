<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Component;

use ArchScaffy\Ast\AstComponentBuilderInterface;

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
