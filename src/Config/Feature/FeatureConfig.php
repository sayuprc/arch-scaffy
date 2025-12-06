<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Feature;

final readonly class FeatureConfig
{
    public function __construct(
        public string $name,
    ) {
    }
}
