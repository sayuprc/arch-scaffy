<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Feature\Validator;

use ArchScaffy\Dto\Blueprint\Feature\Component\Kind;
use ArchScaffy\Validator\Rule\Array\ArrayHasKeyRule;
use ArchScaffy\Validator\Rule\Array\ArrayKeyIsStringRule;
use ArchScaffy\Validator\Rule\ForbiddenIfValueRule;
use ArchScaffy\Validator\Rule\InRule;
use ArchScaffy\Validator\Rule\RequiredRule;
use ArchScaffy\Validator\Rule\Type\ArrayRule;
use ArchScaffy\Validator\Rule\Type\BooleanRule;
use ArchScaffy\Validator\Rule\Type\StringRule;
use ArchScaffy\Validator\RuleSet\RuleSet;
use ArchScaffy\Validator\RuleSet\RuleSetCollection;
use Override;

final readonly class FeatureRuleSetCollection extends RuleSetCollection
{
    #[Override]
    public function all(): array
    {
        $required = new RequiredRule();
        $array = new ArrayRule();
        $keyIsString = new ArrayKeyIsStringRule();
        $string = new StringRule();
        $bool = new BooleanRule();
        $forbidden = new ForbiddenIfValueRule('features.*.components.*.kind', Kind::Interface_);

        return [
            new RuleSet('features', [$required, $array, $keyIsString]),
            new RuleSet('features.*.components', [$required, $array]),
            new RuleSet('features.*.components.*.name', [$required, $string]),
            // TODO 他のレイヤーに存在すること
            new RuleSet('features.*.components.*.layer', [$required, $string, new ArrayHasKeyRule('layers')]),
            new RuleSet('features.*.components.*.kind', [$required, $string, new InRule(Kind::cases())]),
            // TODO どうするか
            new RuleSet('features.*.components.*.placeholders', [$array]),
            // 以下の 3 つは interface だったら required not にする必要がある
            new RuleSet('features.*.components.*.final', [$bool, $forbidden]),
            new RuleSet('features.*.components.*.readonly', [$bool, $forbidden]),
            new RuleSet('features.*.components.*.abstract', [$bool, $forbidden]),
        ];
    }
}
