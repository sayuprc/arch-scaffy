<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Class;

use ArchScaffy\Ast\Builder\AstComponentBuilderInterface;
use ArchScaffy\Ir\ComponentIrInterface;
use Override;

final readonly class ClassIr implements ComponentIrInterface
{
    public function __construct(
        public string $name,
        public bool $isFinal,
        public bool $isReadonly,
    ) {
    }

    #[Override]
    public function name(): string
    {
        return $this->name;
    }

    #[Override]
    public function accept(AstComponentBuilderInterface $builder)
    {
        return $builder->buildClass($this);
    }
}
