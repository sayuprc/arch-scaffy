<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Type;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\RuleInterface;
use ArchScaffy\Validator\Rule\Type\ArrayRule;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ArrayRuleTest extends TestCase
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
            'passes with empty array' => [
                new ArrayRule(),
                [],
                'layers',
                $mock,
                [],
            ],
            'passes with non empty array' => [
                new ArrayRule(),
                ['a', 'b', 'c'],
                'layers',
                $mock,
                [],
            ],
            'target value is not array' => [
                new ArrayRule(),
                '',
                'layers',
                $mock,
                ['The value of "layers" must be a array, string given.'],
            ],
        ];
    }
}
