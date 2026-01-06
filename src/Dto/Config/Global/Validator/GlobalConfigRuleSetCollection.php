<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Global\Validator;

use ArchScaffy\Validator\Rule\RequiredRule;
use ArchScaffy\Validator\Rule\Type\ArrayRule;
use ArchScaffy\Validator\Rule\Type\BooleanRule;
use ArchScaffy\Validator\Rule\Type\StringRule;
use ArchScaffy\Validator\RuleSet\RuleSet;
use ArchScaffy\Validator\RuleSet\RuleSetCollection;
use Override;

final readonly class GlobalConfigRuleSetCollection extends RuleSetCollection
{
    #[Override]
    public function all(): array
    {
        $required = new RequiredRule();

        return [
            new RuleSet('global', [$required, new ArrayRule()]),
            new RuleSet('global.root', [$required, new StringRule()]),
            new RuleSet('global.strict', [$required, new BooleanRule()]),
        ];
    }
}
