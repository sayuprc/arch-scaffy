<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Array;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\Array\ArrayHasKeyRule;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\RuleInterface;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ArrayHasKeyRuleTest extends TestCase
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
                new ArrayHasKeyRule('layers'),
                'Domain',
                'features.User.components.0.layer',
                (function () use ($mock) {
                    $newMock = clone $mock;

                    $newMock->shouldReceive('get')
                        ->with('layers')
                        ->andReturn(['Domain' => []])
                        ->once();

                    return $newMock;
                })(),
                [],
            ],
            'target value is not array' => [
                new ArrayHasKeyRule('layers'),
                'Domain',
                'features.User.components.0.layer',
                (function () use ($mock) {
                    $newMock = clone $mock;

                    $newMock->shouldReceive('get')
                        ->with('layers')
                        ->andReturnNull()
                        ->once();

                    return $newMock;
                })(),
                [
                    'The value for "layers" must be an array, null given.',
                ],
            ],
            'missing key' => [
                new ArrayHasKeyRule('layers'),
                'Domain',
                'features.User.components.0.layer',
                (function () use ($mock) {
                    $newMock = clone $mock;

                    $newMock->shouldReceive('get')
                        ->with('layers')
                        ->andReturn(['layers' => ['UseCase' => [], 'Infrastructure' => []]])
                        ->once();

                    return $newMock;
                })(),
                [
                    'Missing required key "Domain" in the array.',
                ],
            ],
        ];
    }
}
