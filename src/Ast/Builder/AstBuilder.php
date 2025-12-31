<?php

declare(strict_types=1);

namespace ArchScaffy\Ast\Builder;

use ArchScaffy\Ir\FileIr;
use Override;
use PhpParser\Node;
use PhpParser\Node\DeclareItem;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Nop;

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

    #[Override]
    public function build(FileIr $file): array
    {
        if ($file->isStrict) {
            $nodes = [
                new Declare_([new DeclareItem(new Identifier('strict_types'), new Int_(1))]),
                new Nop(),
            ];
        } else {
            $nodes = [];
        }

        return [
            ...$nodes,
            new Namespace_(new Name($file->namespace)),
            $file->component->accept($this->builder),
        ];
    }
}
