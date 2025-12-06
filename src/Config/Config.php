<?php

declare(strict_types=1);

namespace ArchScaffy\Config;

use ArchScaffy\Config\Default\DefaultConfig;
use ArchScaffy\Config\Feature\FeatureConfig;
use ArchScaffy\Config\Layer\LayerConfig;

final readonly class Config
{
    /**
     * @param array<LayerConfig>   $layers
     * @param array<FeatureConfig> $features
     */
    public function __construct(
        public DefaultConfig $default,
        public array $layers,
        public array $features,
    ) {
    }
}
