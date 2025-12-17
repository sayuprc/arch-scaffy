<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Global\Validator;

use ArchScaffy\Validator\Validator;
use Override;

final class GlobalConfigValidator extends Validator implements GlobalConfigValidatorInterface
{
    #[Override]
    public function validate(array $data): bool
    {
        $rootKey = 'global';

        if (! array_key_exists($rootKey, $data)) {
            $this->addMissingKeyError($rootKey, $rootKey);

            return false;
        }

        $global = $data[$rootKey];

        if (! is_array($global)) {
            $this->addInvalidTypeError($rootKey, $rootKey, 'array', $global);

            return false;
        }

        foreach (['root', 'strict'] as $key) {
            if (! array_key_exists($key, $global)) {
                $this->addMissingKeyError("{$rootKey}.{$key}", $key);
            }
        }

        return count($this->errors) === 0;
    }
}
