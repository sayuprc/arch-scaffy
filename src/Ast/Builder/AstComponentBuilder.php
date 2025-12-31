<?php

declare(strict_types=1);

namespace ArchScaffy\Ast\Builder;

use ArchScaffy\Ir\Class\ClassIrInterface;
use ArchScaffy\Ir\Class\InterfaceIr;
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
    public function buildClass(ClassIrInterface $class): Node
    {
        $stmt = $this->factory->class($class->name());

        if ($class->isFinal()) {
            $stmt->makeFinal();
        }

        if ($class->isReadonly()) {
            $stmt->makeReadonly();
        }

        if ($class->isAbstract()) {
            $stmt->makeAbstract();
        }

        return $stmt->getNode();
    }

    #[Override]
    public function buildInterface(InterfaceIr $interface): Node
    {
        return $this->factory->interface($interface->name())->getNode();
    }
}
