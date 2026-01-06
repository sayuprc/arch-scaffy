<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Array;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\Array\ArrayKeyIsStringRule;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\RuleInterface;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ArrayKeyIsStringRuleTest extends TestCase
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
                new ArrayKeyIsStringRule(),
                ['Domain' => [], 'UseCase' => []],
                'layers',
                $mock,
                [],
            ],
            'key is not string' => [
                new ArrayKeyIsStringRule(),
                [0 => [], 1 => []],
                'layers',
                $mock,
                [
                    'Array key "0" must be a string, int given.',
                    'Array key "1" must be a string, int given.',
                ],
            ],
            'mixed' => [
                new ArrayKeyIsStringRule(),
                ['Domain' => [], 1 => []],
                'layers',
                $mock,
                [
                    'Array key "1" must be a string, int given.',
                ],
            ],
        ];
    }
}
