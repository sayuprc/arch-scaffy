<?php

declare(strict_types=1);

namespace ArchScaffy\Ast;

use ArchScaffy\Ir\FileIr;
use PhpParser\Node;
use PhpParser\Node\DeclareItem;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Stmt\Declare_;

/**
 * @template-implements AstBuilderInterface<array<Node>>
 */
final readonly class AstBuilder implements AstBuilderInterface
{
    /**
     * @param AstComponentBuilderInterface<Node> $builder
     */
    public function __construct(private AstComponentBuilderInterface $builder)
    {
    }

    public function build(FileIr $file): array
    {
        $nodes = [];

        if ($file->isStrict) {
            $nodes[] = new Declare_([new DeclareItem(new Identifier('strict_types'), new Int_(1))]);
        }

        $nodes[] = $file->component->accept($this->builder);

        return $nodes;
    }
}
