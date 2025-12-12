<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Component;

interface ComponentIrInterface
{
    public function name(): string;

    public function kind(): Kind;
}
