<?php

declare(strict_types=1);

namespace ArchScaffy\Validator;

interface ValidatorInterface
{
    /**
     * @param array<mixed> $data
     */
    public function validate(array $data): bool;

    /**
     * @return array<ValidationError>
     */
    public function getErrors(): array;
}
