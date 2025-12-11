<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Component;

use ArchScaffy\Ir\Converter\IrConverterInterface;

final readonly class InterfaceIr implements ComponentIrInterface
{
    public function __construct(
        public string $namespace,
        public string $name,
    ) {
    }

    public function accept(IrConverterInterface $printer)
    {
        return $printer->toInterface($this);
    }
}
