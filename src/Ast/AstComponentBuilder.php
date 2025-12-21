<?php

declare(strict_types=1);

namespace ArchScaffy\Ast;

use ArchScaffy\Ir\Component\AbstractClassIr;
use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;
use Override;
use PhpParser\BuilderFactory;
use PhpParser\Node;

/**
 * @template-implements AstComponentBuilderInterface<Node>
 */
final readonly class AstComponentBuilder implements AstComponentBuilderInterface
{
    public function __construct(private BuilderFactory $factory)
    {
    }

    #[Override]
    public function buildClass(ClassIr $class): Node
    {
        $stmt = $this->factory->class($class->name);

        if ($class->isFinal) {
            $stmt->makeFinal();
        }

        if ($class->isReadonly) {
            $stmt->makeReadonly();
        }

        return $stmt->getNode();
    }

    #[Override]
    public function buildAbstractClass(AbstractClassIr $abstractClass)
    {
        $stmt = $this->factory->class($abstractClass->name)
            ->makeAbstract();

        if ($abstractClass->isReadonly) {
            $stmt->makeReadonly();
        }

        return $stmt->getNode();
    }

    #[Override]
    public function buildInterface(InterfaceIr $interface): Node
    {
        return $this->factory->interface($interface->name())->getNode();
    }
}
