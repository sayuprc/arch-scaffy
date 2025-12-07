<?php

declare(strict_types=1);

namespace ArchScaffy\Config;

final readonly class Config
{
    public function __construct(
        public GlobalConfig $global,
        public ClassConfig $class,
    ) {
    }
}
