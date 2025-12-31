<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Class;

use ArchScaffy\Ast\Builder\AstComponentBuilderInterface;
use Override;

final readonly class AbstractClassIr implements ClassIrInterface
{
    public function __construct(
        private string $name,
        private bool $isReadonly,
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

    #[Override]
    public function isFinal(): bool
    {
        return false;
    }

    #[Override]
    public function isReadonly(): bool
    {
        return $this->isReadonly;
    }

    #[Override]
    public function isAbstract(): bool
    {
        return true;
    }
}
