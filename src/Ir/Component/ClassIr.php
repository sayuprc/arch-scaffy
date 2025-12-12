<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Component;

final readonly class ClassIr implements ComponentIrInterface
{
    public function __construct(public string $name)
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function kind(): Kind
    {
        return Kind::ClassKind;
    }
}
