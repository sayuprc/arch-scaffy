<?php

declare(strict_types=1);

namespace Tests\Unit\Validator\Rule\Type;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\Rule\FailurePolicy;
use ArchScaffy\Validator\Rule\RequiredRule;
use ArchScaffy\Validator\Rule\RuleInterface;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RequiredRuleTest extends TestCase
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
                new RequiredRule(),
                null,
                'layers',
                (function () use ($mock) {
                    $newMock = clone $mock;

                    $newMock->shouldReceive('has')
                        ->with('layers')
                        ->andReturnTrue()
                        ->once();

                    return $newMock;
                })(),
                [],
            ],
            'missing required key' => [
                new RequiredRule(),
                null,
                'layers',
                (function () use ($mock) {
                    $newMock = clone $mock;

                    $newMock->shouldReceive('has')
                        ->with('layers')
                        ->andReturnFalse()
                        ->once();

                    return $newMock;
                })(),
                ['Missing required key: "layers".'],
            ],
        ];
    }
}
