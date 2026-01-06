<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Validator;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\ValidationError;

interface ConfigValidatorInterface
{
    public function validate(ValidationContextInterface $context): bool;

    /**
     * @return array<ValidationError>
     */
    public function getErrors(): array;
}
