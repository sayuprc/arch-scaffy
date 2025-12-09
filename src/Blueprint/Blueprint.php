<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint;

use ArchScaffy\Blueprint\Feature\Feature;
use ArchScaffy\Blueprint\Layer\Layer;

final readonly class Blueprint
{
    /**
     * @param array<string, Layer>   $layers
     * @param array<string, Feature> $features
     */
    public function __construct(
        public array $layers,
        public array $features,
    ) {
    }
}
