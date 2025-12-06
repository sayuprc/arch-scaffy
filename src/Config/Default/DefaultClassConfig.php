<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Default;

final readonly class DefaultClassConfig
{
    public function __construct(
        public bool $final,
        public bool $readonly,
    ) {
    }
}
