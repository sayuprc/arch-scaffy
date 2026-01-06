<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Type;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\RuleInterface;
use ArchScaffy\Validator\Rule\Type\StringRule;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StringRuleTest extends TestCase
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
            'passes with empty string' => [
                new StringRule(),
                '',
                'global.root',
                $mock,
                [],
            ],
            'passes with non empty string' => [
                new StringRule(),
                'non-empty-string',
                'global.root',
                $mock,
                [],
            ],
            'target value is not string' => [
                new StringRule(),
                0,
                'global.root',
                $mock,
                ['The value of "global.root" must be a string, int given.'],
            ],
        ];
    }
}
