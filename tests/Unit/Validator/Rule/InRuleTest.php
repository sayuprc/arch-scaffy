<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Type;

use ArchScaffy\Dto\Blueprint\Feature\Component\Kind;
use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\InRule;
use ArchScaffy\Validator\Rule\RuleInterface;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InRuleTest extends TestCase
{
    #[Test]
    #[DataProvider('validationTestDataProvider')]
    public function validationTest(
        RuleInterface $rule,
        mixed $value,
        int|string $key,
        ValidationContextInterface $context,
        array $messages
    ): void {
        $this->assertSame($messages, $rule->validate($value, $key, $context));
        $this->assertSame(FailurePolicy::Continue, $rule->failurePolicy());
    }

    public static function validationTestDataProvider(): array
    {
        $mock = Mockery::mock(ValidationContextInterface::class);

        return [
            'passes' => [
                new InRule(Kind::cases()),
                Kind::Class_->value,
                'features.User.components.0.kind',
                $mock,
                [],
            ],
            'value is not allowed' => [
                new InRule(Kind::cases()),
                'not found',
                'features.User.components.0.kind',
                $mock,
                ['The value "not found" is not one of the allowed values.'],
            ],
        ];
    }
}
