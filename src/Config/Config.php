<?php

declare(strict_types=1);

namespace ArchScaffy\Config;

use ArchScaffy\Config\Class\ClassConfig;
use ArchScaffy\Config\Global\GlobalConfig;

final readonly class Config
{
    public function __construct(
        public GlobalConfig $global,
        public ClassConfig $class,
    ) {
    }
}
