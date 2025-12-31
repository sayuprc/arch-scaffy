<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Global\Validator;

use ArchScaffy\Validator\ValidatorInterface;
use Override;

/**
 * @phpstan-type validated_global array{global: array{strict: mixed}}
 */
interface GlobalConfigValidatorInterface extends ValidatorInterface
{
    /**
     * @phpstan-assert-if-true validated_global $data
     */
    #[Override]
    public function validate(array $data): bool;
}
