<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Validator;

use ArchScaffy\Dto\Config\Class\Validator\ClassConfigValidatorInterface;
use ArchScaffy\Dto\Config\Global\Validator\GlobalConfigValidatorInterface;
use ArchScaffy\Validator\ValidatorInterface;
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
