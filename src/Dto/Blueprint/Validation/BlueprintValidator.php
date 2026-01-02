<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Validation;

use ArchScaffy\Dto\Blueprint\Feature\Validation\FeatureValidatorInterface;
use ArchScaffy\Dto\Blueprint\Layer\Validation\LayerValidatorInterface;
use ArchScaffy\Validation\Validator;
use Override;

final class BlueprintValidator extends Validator implements BlueprintValidatorInterface
{
    public function __construct(
        private readonly LayerValidatorInterface $layerValidator,
        private readonly FeatureValidatorInterface $featureValidator,
    ) {
    }

    #[Override]
    public function validate(array $data): bool
    {
        $this->layerValidator->validate($data);
        $this->featureValidator->validate($data);

        $this->errors = array_merge(
            $this->layerValidator->getErrors(),
            $this->featureValidator->getErrors(),
        );

        return count($this->errors) === 0;
    }
}
