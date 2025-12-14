<?php

declare(strict_types=1);

namespace ArchScaffy\Ast;

use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;

/**
 * @template-covariant T
 */
interface AstComponentBuilderInterface
{
    /**
     * @return T
     */
    public function buildClass(ClassIr $class);

    /**
     * @return T
     */
    public function buildInterface(InterfaceIr $interface);
}
