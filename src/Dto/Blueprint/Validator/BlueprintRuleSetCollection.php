<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Validator;

use ArchScaffy\Dto\Blueprint\Feature\Validator\FeatureRuleSetCollection;
use ArchScaffy\Dto\Blueprint\Layer\Validator\LayerRuleSetCollection;
use ArchScaffy\Validator\RuleSet\RuleSetCollection;
use Override;

final readonly class BlueprintRuleSetCollection extends RuleSetCollection
{
    public function __construct(
        private readonly LayerRuleSetCollection $layerRuleSetCollection,
        private readonly FeatureRuleSetCollection $featureRuleSetCollection,
    ) {
    }

    #[Override]
    public function all(): array
    {
        return array_merge(
            $this->layerRuleSetCollection->all(),
            $this->featureRuleSetCollection->all(),
        );
    }
}
