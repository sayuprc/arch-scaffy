<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Class;

use ArchScaffy\Ir\ComponentIrInterface;

interface ClassIrInterface extends ComponentIrInterface
{
    public function isFinal(): bool;

    public function isReadonly(): bool;

    public function isAbstract(): bool;
}
