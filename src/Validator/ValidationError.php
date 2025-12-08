<?php

declare(strict_types=1);

namespace ArchScaffy\Validator;

final readonly class ValidationError
{
    public function __construct(
        public string $path,
        public string $message,
    ) {
    }
}
