<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config;

use ArchScaffy\Dto\Config\Class\ClassConfig;
use ArchScaffy\Dto\Config\Global\GlobalConfig;

final readonly class Config
{
    public function __construct(
        public GlobalConfig $global,
        public ClassConfig $class,
    ) {
    }
}
