<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature\Validator;

use ArchScaffy\Validator\ValidatorInterface;
use Override;

/**
 * @phpstan-type component array{name: mixed, layer: mixed, kind: mixed}
 * @phpstan-type validated_feature array{features: array<array{components: array<component>}>}
 */
interface FeatureValidatorInterface extends ValidatorInterface
{
    /**
     * @phpstan-assert-if-true validated_feature $data
     */
    #[Override]
    public function validate(array $data): bool;
}
