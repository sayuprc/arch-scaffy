<?php

declare(strict_types=1);

namespace ArchScaffy\Ast\Builder;

use ArchScaffy\Ir\Class\AbstractClassIr;
use ArchScaffy\Ir\Class\ClassIr;
use ArchScaffy\Ir\Class\InterfaceIr;

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
    public function buildAbstractClass(AbstractClassIr $abstractClass);

    /**
     * @return T
     */
    public function buildInterface(InterfaceIr $interface);
}
