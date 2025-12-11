<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Converter;

use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;
use PhpParser\BuilderFactory;
use PhpParser\Node;

/**
 * @template-implements IrConverterInterface<Node>
 */
final readonly class IrConverter implements IrConverterInterface
{
    public function __construct(private BuilderFactory $factory)
    {
    }

    public function toClass(ClassIr $class): Node
    {
        return $this->factory->namespace($class->namespace)
            ->addStmt($this->factory->class($class->name))
            ->getNode();
    }

    public function toInterface(InterfaceIr $interface): Node
    {
        return $this->factory->namespace($interface->namespace)
            ->addStmt($this->factory->interface($interface->name))
            ->getNode();
    }
}
