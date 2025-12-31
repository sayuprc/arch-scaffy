<?php

declare(strict_types=1);

namespace ArchScaffy\Ast\Builder;

use ArchScaffy\Ir\Class\ClassIrInterface;
use ArchScaffy\Ir\Class\InterfaceIr;

/**
 * @template-covariant T
 */
interface AstComponentBuilderInterface
{
    /**
     * @return T
     */
    public function buildClass(ClassIrInterface $class);

    /**
     * @return T
     */
    public function buildInterface(InterfaceIr $interface);
}
