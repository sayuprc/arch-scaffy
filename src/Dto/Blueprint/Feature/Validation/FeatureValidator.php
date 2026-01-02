<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Feature\Validation;

use ArchScaffy\Validation\Validator;
use Override;

final class FeatureValidator extends Validator implements FeatureValidatorInterface
{
    #[Override]
    public function validate(array $data): bool
    {
        $rootKey = 'features';

        if (! array_key_exists($rootKey, $data)) {
            $this->addMissingKeyError($rootKey, $rootKey);

            return false;
        }

        $features = $data[$rootKey];

        if (! is_array($features)) {
            $this->addInvalidTypeError($rootKey, $rootKey, 'array', $features);

            return false;
        }

        foreach ($features as $name => $values) {
            if (! is_array($values)) {
                $this->addInvalidTypeError("{$rootKey}.{$name}", $name, 'array', $values);

                continue;
            }

            if (! array_key_exists('components', $values)) {
                $this->addMissingKeyError("{$rootKey}.{$name}.components", 'components');

                continue;
            }

            $components = $values['components'];

            if (! is_array($components)) {
                $this->addInvalidTypeError("{$rootKey}.{$name}.components", 'components', 'array', $components);

                continue;
            }

            foreach ($components as $index => $component) {
                if (! is_array($component)) {
                    $this->addInvalidTypeError("{$rootKey}.{$name}.components.{$index}", 'components', 'array', $component);

                    continue;
                }

                foreach (['name', 'layer', 'kind'] as $key) {
                    if (! array_key_exists($key, $component)) {
                        $this->addMissingKeyError("{$rootKey}.{$name}.components.{$index}.{$key}", $key);
                    }
                }
            }
        }

        return count($this->errors) === 0;
    }
}
