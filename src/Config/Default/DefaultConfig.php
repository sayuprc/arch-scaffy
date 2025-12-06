<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Default;

final readonly class DefaultConfig
{
    public function __construct(
        public DefaultClassConfig $class,
    ) {
    }
}
