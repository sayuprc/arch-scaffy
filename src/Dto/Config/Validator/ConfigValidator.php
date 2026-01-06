<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Validator;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\ValidatorInterface;
use Override;

final class ConfigValidator implements ConfigValidatorInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private ConfigRuleSetCollection $collection
    ) {
    }

    #[Override]
    public function validate(ValidationContextInterface $context): bool
    {
        return $this->validator->validate($this->collection, $context);
    }

    #[Override]
    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }
}
