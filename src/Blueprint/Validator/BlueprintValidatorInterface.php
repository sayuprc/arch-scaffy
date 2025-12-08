<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Validator;

use ArchScaffy\Blueprint\Feature\Validator\FeatureValidatorInterface;
use ArchScaffy\Blueprint\Layer\Validator\LayerValidatorInterface;
use ArchScaffy\Validator\ValidatorInterface;
use Override;

/**
 * @phpstan-import-type validated_layer from LayerValidatorInterface
 * @phpstan-import-type validated_feature from FeatureValidatorInterface
 *
 * @phpstan-type validated_blueprint array{layers: validated_layer['layers'], features: validated_feature['features']}
 */
interface BlueprintValidatorInterface extends ValidatorInterface
{
    /**
     * @phpstan-assert-if-true validated_blueprint $data
     */
    #[Override]
    public function validate(array $data): bool;
}
