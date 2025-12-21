<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Component;

use ArchScaffy\Ast\AstComponentBuilderInterface;
use Override;

final readonly class ClassIr implements ComponentIrInterface
{
    public function __construct(
        public string $name,
        public bool $isFinal,
        public bool $isReadonly,
        public bool $isAbstract,
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
