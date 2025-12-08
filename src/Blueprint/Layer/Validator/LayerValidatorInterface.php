<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Layer\Validator;

use ArchScaffy\Validator\ValidatorInterface;
use Override;

/**
 * @phpstan-type validated_layer array{layers: array<array{output: mixed, namespace: mixed}>}
 */
interface LayerValidatorInterface extends ValidatorInterface
{
    /**
     * @phpstan-assert-if-true validated_layer $data
     */
    #[Override]
    public function validate(array $data): bool;
}
