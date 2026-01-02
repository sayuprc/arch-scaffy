<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Layer\Validation;

use ArchScaffy\Validation\Validator;
use Override;

final class LayerValidator extends Validator implements LayerValidatorInterface
{
    #[Override]
    public function validate(array $data): bool
    {
        $rootKey = 'layers';

        if (! array_key_exists($rootKey, $data)) {
            $this->addMissingKeyError($rootKey, $rootKey);

            return false;
        }

        $layers = $data[$rootKey];

        if (! is_array($layers)) {
            $this->addInvalidTypeError($rootKey, $rootKey, 'array', $layers);

            return false;
        }

        foreach ($layers as $name => $values) {
            if (! is_array($values)) {
                $this->addInvalidTypeError("{$rootKey}.{$name}", $name, 'array', $values);

                continue;
            }

            foreach (['output', 'namespace'] as $key) {
                if (! array_key_exists($key, $values)) {
                    $this->addMissingKeyError("{$rootKey}.{$name}.{$key}", $key);
                }
            }
        }

        return count($this->errors) === 0;
    }
}
