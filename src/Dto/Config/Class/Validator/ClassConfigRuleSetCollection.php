<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config\Class\Validator;

use ArchScaffy\Validator\Rule\RequiredRule;
use ArchScaffy\Validator\Rule\Type\ArrayRule;
use ArchScaffy\Validator\Rule\Type\BooleanRule;
use ArchScaffy\Validator\RuleSet\RuleSet;
use ArchScaffy\Validator\RuleSet\RuleSetCollection;
use Override;

final readonly class ClassConfigRuleSetCollection extends RuleSetCollection
{
    #[Override]
    public function all(): array
    {
        $required = new RequiredRule();
        $bool = new BooleanRule();

        return [
            new RuleSet('class', [$required, new ArrayRule()]),
            new RuleSet('class.final', [$required, $bool]),
            new RuleSet('class.readonly', [$required, $bool]),
        ];
    }
}
