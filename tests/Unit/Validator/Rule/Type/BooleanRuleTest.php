<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Type;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\RuleInterface;
use ArchScaffy\Validator\Rule\Type\BooleanRule;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BooleanRuleTest extends TestCase
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
            'passes with true' => [
                new BooleanRule(),
                true,
                'class.final',
                $mock,
                [],
            ],
            'passes with false' => [
                new BooleanRule(),
                false,
                'class.final',
                $mock,
                [],
            ],
            'target value is not bool' => [
                new BooleanRule(),
                '',
                'class.final',
                $mock,
                ['The value of "class.final" must be a bool, string given.'],
            ],
        ];
    }
}
