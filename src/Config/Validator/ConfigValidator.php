<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Validator;

use ArchScaffy\Config\Class\Validator\ClassConfigValidatorInterface;
use ArchScaffy\Config\Global\Validator\GlobalConfigValidatorInterface;
use ArchScaffy\Validator\Validator;
use Override;

final class ConfigValidator extends Validator implements ConfigValidatorInterface
{
    public function __construct(
        private GlobalConfigValidatorInterface $globalConfigValidator,
        private ClassConfigValidatorInterface $classConfigValidator,
    ) {
    }

    #[Override]
    public function validate(array $data): bool
    {
        $this->globalConfigValidator->validate($data);
        $this->classConfigValidator->validate($data);

        $this->errors = array_merge(
            $this->globalConfigValidator->getErrors(),
            $this->classConfigValidator->getErrors(),
        );

        return count($this->errors) === 0;
    }
}
