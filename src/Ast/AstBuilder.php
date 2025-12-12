<?php

declare(strict_types=1);

namespace ArchScaffy\Ast;

use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;
use PhpParser\BuilderFactory;
use PhpParser\Node;

/**
 * @template-implements AstBuilderInterface<Node>
 */
final readonly class AstBuilder implements AstBuilderInterface
{
    public function __construct(private BuilderFactory $factory)
    {
    }

    public function buildClass(ClassIr $class): Node
    {
        return $this->factory->class($class->name)->getNode();
    }

    public function buildInterface(InterfaceIr $interface): Node
    {
        return $this->factory->interface($interface->name)->getNode();
    }
}
