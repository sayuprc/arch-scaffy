<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Validator;

use ArchScaffy\Dto\Config\Class\Validator\ClassConfigRuleSetCollection;
use ArchScaffy\Dto\Config\Global\Validator\GlobalConfigRuleSetCollection;
use ArchScaffy\Validator\RuleSet\RuleSetCollection;
use Override;

final readonly class ConfigRuleSetCollection extends RuleSetCollection
{
    public function __construct(
        private GlobalConfigRuleSetCollection $globalConfigRuleSetCollection,
        private ClassConfigRuleSetCollection $classConfigRuleSetCollection,
    ) {
    }

    #[Override]
    public function all(): array
    {
        return array_merge(
            $this->globalConfigRuleSetCollection->all(),
            $this->classConfigRuleSetCollection->all(),
        );
    }
}
