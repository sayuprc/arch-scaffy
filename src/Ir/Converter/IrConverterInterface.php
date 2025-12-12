<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Converter;

use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;

/**
 * @template-covariant T
 */
interface IrConverterInterface
{
    /**
     * @return T
     */
    public function toClass(ClassIr $class);

    /**
     * @return T
     */
    public function toInterface(InterfaceIr $interface);
}
