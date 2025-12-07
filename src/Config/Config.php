<?php

declare(strict_types=1);

namespace ArchScaffy\Config;

use ArchScaffy\Config\Default\DefaultConfig;

final readonly class Config
{
    public function __construct(public DefaultConfig $default)
    {
    }
}
