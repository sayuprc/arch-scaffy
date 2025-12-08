<?php

declare(strict_types=1);

namespace ArchScaffy\Validator;

use Override;

abstract class Validator implements ValidatorInterface
{
    /**
     * @var array<ValidationError>
     */
    protected array $errors = [];

    #[Override]
    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function addMissingKeyError(string $path, string $key): void
    {
        $this->errors[] = new ValidationError(
            $path,
            sprintf('Missing required key: "%s"', $key)
        );
    }

    protected function addInvalidTypeError(string $path, string $key, string $expected, mixed $value): void
    {
        $this->errors[] = new ValidationError(
            $path,
            sprintf(
                'Invalid type for key "%s": expected %s got %s',
                $key,
                $expected,
                get_debug_type($value)
            )
        );
    }
}
