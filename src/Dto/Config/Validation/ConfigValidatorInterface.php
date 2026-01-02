<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Validation;

use ArchScaffy\Dto\Config\Class\Validation\ClassConfigValidatorInterface;
use ArchScaffy\Dto\Config\Global\Validation\GlobalConfigValidatorInterface;
use ArchScaffy\Validation\ValidatorInterface;
use Override;

/**
 * @phpstan-import-type validated_global from GlobalConfigValidatorInterface
 * @phpstan-import-type validated_class from ClassConfigValidatorInterface
 *
 * @phpstan-type validated_config array{global: validated_global['global'], class: validated_class['class']}
 */
interface ConfigValidatorInterface extends ValidatorInterface
{
    /**
     * @phpstan-assert-if-true validated_config $data
     */
    #[Override]
    public function validate(array $data): bool;
}
