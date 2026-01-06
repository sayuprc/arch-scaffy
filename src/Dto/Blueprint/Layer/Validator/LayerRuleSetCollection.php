<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Layer\Validator;

use ArchScaffy\Validator\Rule\Array\ArrayKeyIsStringRule;
use ArchScaffy\Validator\Rule\RequiredRule;
use ArchScaffy\Validator\Rule\Type\ArrayRule;
use ArchScaffy\Validator\Rule\Type\StringRule;
use ArchScaffy\Validator\RuleSet\RuleSet;
use ArchScaffy\Validator\RuleSet\RuleSetCollection;
use Override;

final readonly class LayerRuleSetCollection extends RuleSetCollection
{
    #[Override]
    public function all(): array
    {
        $required = new RequiredRule();
        $string = new StringRule();

        return [
            new RuleSet('layers', [$required, new ArrayRule(), new ArrayKeyIsStringRule()]),
            new RuleSet('layers.*.output', [$required, $string]),
            new RuleSet('layers.*.namespace', [$required, $string]),
        ];
    }
}
