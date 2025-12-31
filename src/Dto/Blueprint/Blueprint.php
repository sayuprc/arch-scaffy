<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint;

use ArchScaffy\Dto\Blueprint\Feature\Feature;
use ArchScaffy\Dto\Blueprint\Layer\Layer;
use LogicException;

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

    public function getLayer(string $layer): Layer
    {
        // TODO enhance validation
        return $this->layers[$layer] ?? throw new LogicException("Attempted to reference a non-existent Layer: {$layer}");
    }
}
