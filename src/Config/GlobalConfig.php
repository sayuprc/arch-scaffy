<?php

declare(strict_types=1);

namespace ArchScaffy\Config;

final readonly class GlobalConfig
{
    public function __construct(public bool $strict)
    {
    }
}
