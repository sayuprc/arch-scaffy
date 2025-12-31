<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Global;

final readonly class GlobalConfig
{
    public function __construct(
        public string $root,
        public bool $strict,
    ) {
    }
}
