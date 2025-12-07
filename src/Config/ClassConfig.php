<?php

declare(strict_types=1);

namespace ArchScaffy\Config;

final readonly class ClassConfig
{
    public function __construct(
        public bool $final,
        public bool $readonly,
    ) {
    }
}
