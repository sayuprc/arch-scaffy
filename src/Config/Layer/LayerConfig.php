<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Layer;

final readonly class LayerConfig
{
    public function __construct(
        public string $name,
        public Layer $layer,
    ) {
    }
}
