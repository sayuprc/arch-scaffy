<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature;

use ArchScaffy\Blueprint\Feature\Component\ComponentInterface;

final readonly class Feature
{
    /**
     * @param array<ComponentInterface> $components
     */
    public function __construct(public array $components)
    {
    }
}
