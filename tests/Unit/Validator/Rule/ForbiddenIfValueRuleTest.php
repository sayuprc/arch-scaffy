<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Type;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\ForbiddenIfValueRule;
use ArchScaffy\Validator\Rule\RuleInterface;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ForbiddenIfValueRuleTest extends TestCase
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
        $this->assertSame(FailurePolicy::Abort, $rule->failurePolicy());
    }

    public static function validationTestDataProvider(): array
    {
        $mock = Mockery::mock(ValidationContextInterface::class);

        return [
            'passes' => [
                new ForbiddenIfValueRule('features.User.components.*.abstract', true),
                null,
                'features.User.components.0.final',
                (function () use ($mock) {
                    $newMock = clone $mock;

                    $newMock->shouldReceive('getScope')
                        ->with('features.User.components.0.final', 'features.User.components.*.abstract')
                        ->andReturnUsing(function () use ($mock, $newMock) {
                            $newMock = clone $mock;

                            $newMock->shouldReceive('get')
                                ->with('abstract')
                                ->andReturnTrue()
                                ->once();

                            return $newMock;
                        })
                        ->once();

                    $newMock->shouldReceive('has')
                        ->with('features.User.components.0.final')
                        ->andReturnFalse()
                        ->once();

                    return $newMock;
                })(),
                [],
            ],
            'field must not be present' => [
                new ForbiddenIfValueRule('features.User.components.*.abstract', true),
                null,
                'features.User.components.0.final',
                (function () use ($mock) {
                    $newMock = clone $mock;

                    $newMock->shouldReceive('getScope')
                        ->with('features.User.components.0.final', 'features.User.components.*.abstract')
                        ->andReturnUsing(function () use ($mock, $newMock) {
                            $newMock = clone $mock;

                            $newMock->shouldReceive('get')
                                ->with('abstract')
                                ->andReturnTrue()
                                ->once();

                            return $newMock;
                        })
                        ->once();

                    $newMock->shouldReceive('has')
                        ->with('features.User.components.0.final')
                        ->andReturnTrue()
                        ->once();

                    return $newMock;
                })(),
                ['The field "features.User.components.0.final" must not be present when "abstract" is true.'],
            ],
        ];
    }
}
