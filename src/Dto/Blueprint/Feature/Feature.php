<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Feature;

use ArchScaffy\Dto\Blueprint\Feature\Component\ComponentInterface;

final readonly class Feature
{
    /**
     * @param array<ComponentInterface> $components
     */
    public function __construct(public array $components)
    {
    }
}
