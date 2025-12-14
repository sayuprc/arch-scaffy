<?php

declare(strict_types=1);

namespace ArchScaffy\Ast;

use ArchScaffy\Ir\FileIr;

/**
 * @template-covariant T
 */
interface AstBuilderInterface
{
    /**
     * @return T
     */
    public function build(FileIr $file);
}
