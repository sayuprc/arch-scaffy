<?php

declare(strict_types=1);

namespace ArchScaffy\Ast\Printer;

/**
 * @template T
 */
interface PrinterInterface
{
    /**
     * @param array<T> $asts
     */
    public function print(array $asts): string;
}
