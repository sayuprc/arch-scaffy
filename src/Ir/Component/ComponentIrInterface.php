<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Component;

use ArchScaffy\Ir\Converter\IrConverterInterface;

interface ComponentIrInterface
{
    /**
     * @template T
     *
     * @param IrConverterInterface<T> $printer
     *
     * @return T
     */
    public function accept(IrConverterInterface $printer);
}
