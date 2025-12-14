<?php

declare(strict_types=1);

namespace ArchScaffy\Ast\Printer;

use Override;
use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard;

/**
 * @template-implements PrinterInterface<Node>
 */
final readonly class Printer implements PrinterInterface
{
    public function __construct(private Standard $printer)
    {
    }

    #[Override]
    public function print($asts): string
    {
        return $this->printer->prettyPrintFile($asts);
    }
}
