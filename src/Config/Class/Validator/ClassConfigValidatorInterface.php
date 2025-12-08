<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Class\Validator;

use ArchScaffy\Validator\ValidatorInterface;
use Override;

/**
 * @phpstan-type validated_class array{class: array{final: mixed, readonly: mixed}}
 */
interface ClassConfigValidatorInterface extends ValidatorInterface
{
    /**
     * @phpstan-assert-if-true validated_class $data
     */
    #[Override]
    public function validate(array $data): bool;
}
