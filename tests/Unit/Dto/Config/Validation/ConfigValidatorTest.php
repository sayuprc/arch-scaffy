<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Config\Validation;

use ArchScaffy\Dto\Config\Class\Validation\ClassConfigValidatorInterface;
use ArchScaffy\Dto\Config\Global\Validation\GlobalConfigValidatorInterface;
use ArchScaffy\Dto\Config\Validation\ConfigValidator;
use ArchScaffy\Validation\ValidationError;
use Mockery;
use Mockery\MockInterface;
use Override;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConfigValidatorTest extends TestCase
{
    private GlobalConfigValidatorInterface&MockInterface $globalConfigValidator;

    private ClassConfigValidatorInterface&MockInterface $classConfigValidator;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->globalConfigValidator = Mockery::mock(GlobalConfigValidatorInterface::class);
        $this->classConfigValidator = Mockery::mock(ClassConfigValidatorInterface::class);
    }

    #[Test]
    public function correctConfig(): void
    {
        $validator = $this->getInstance();

        $data = [
            'global' => [
                'strict' => true,
            ],
            'class' => [
                'final' => false,
                'readonly' => true,
            ],
        ];

        $this->globalConfigValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnTrue()
            ->once();

        $this->classConfigValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnTrue()
            ->once();

        $this->globalConfigValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([])
            ->once();

        $this->classConfigValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([])
            ->once();

        $this->assertTrue($validator->validate($data));
    }

    #[Test]
    public function incorrectConfig(): void
    {
        $validator = $this->getInstance();

        $data = [];
        $errors = [
            new ValidationError('global', 'Missing required key: "global"'),
            new ValidationError('class', 'Missing required key: "class"'),
        ];

        $this->globalConfigValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnFalse()
            ->once();

        $this->classConfigValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnFalse()
            ->once();

        $this->globalConfigValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([new ValidationError('global', 'Missing required key: "global"')])
            ->once();

        $this->classConfigValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([new ValidationError('class', 'Missing required key: "class"')])
            ->once();

        $this->assertFalse($validator->validate($data));
        $this->assertCount(count($errors), $validator->getErrors());
        $this->assertEquals($errors, $validator->getErrors());
    }

    private function getInstance(): ConfigValidator
    {
        return new ConfigValidator(
            $this->globalConfigValidator,
            $this->classConfigValidator,
        );
    }
}
