<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Class\Validator;

use ArchScaffy\Validator\Validator;
use Override;

final class ClassConfigValidator extends Validator implements ClassConfigValidatorInterface
{
    #[Override]
    public function validate(array $data): bool
    {
        $rootKey = 'class';

        if (! array_key_exists($rootKey, $data)) {
            $this->addMissingKeyError($rootKey, $rootKey);

            return false;
        }

        $class = $data[$rootKey];

        if (! is_array($class)) {
            $this->addInvalidTypeError($rootKey, $rootKey, 'array', $class);

            return false;
        }

        foreach (['final', 'readonly'] as $key) {
            if (! array_key_exists($key, $class)) {
                $this->addMissingKeyError("{$rootKey}.{$key}", $key);
            }
        }

        return count($this->errors) === 0;
    }
}
