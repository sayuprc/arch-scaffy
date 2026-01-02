<?php

declare(strict_types=1);

namespace ArchScaffy\Validation;

final readonly class ValidationError
{
    public function __construct(
        public string $path,
        public string $message,
    ) {
    }
}
