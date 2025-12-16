<?php

declare(strict_types=1);

namespace Tests\Unit\Blueprint\Validator;

use ArchScaffy\Blueprint\Feature\Validator\FeatureValidatorInterface;
use ArchScaffy\Blueprint\Layer\Validator\LayerValidatorInterface;
use ArchScaffy\Blueprint\Validator\BlueprintValidator;
use ArchScaffy\Validator\ValidationError;
use Mockery;
use Mockery\MockInterface;
use Override;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BlueprintValidatorTest extends TestCase
{
    private LayerValidatorInterface&MockInterface $layerValidator;

    private FeatureValidatorInterface&MockInterface $featureValidator;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->layerValidator = Mockery::mock(LayerValidatorInterface::class);
        $this->featureValidator = Mockery::mock(FeatureValidatorInterface::class);
    }

    #[Test]
    public function correctBlueprint(): void
    {
        $validator = $this->getInstance();

        $data = [
            'layers' => [
                'Domain' => [
                    'output' => 'app/Domain',
                    'namespace' => 'App\Domain',
                ],
            ],
            'features' => [
                'User' => [
                    'components' => [
                        [
                            'name' => 'UserId',
                            'layer' => 'Domain',
                            'kind' => 'class',
                        ],
                    ],
                ],
            ],
        ];

        $this->layerValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnTrue()
            ->once();

        $this->featureValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnTrue()
            ->once();

        $this->layerValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([])
            ->once();

        $this->featureValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([])
            ->once();

        $this->assertTrue($validator->validate($data));
    }

    #[Test]
    public function incorrectBlueprint(): void
    {
        $validator = $this->getInstance();

        $data = [];
        $errors = [
            new ValidationError('layers', 'Missing required key: "layers"'),
            new ValidationError('features', 'Missing required key: "features"'),
        ];

        $this->layerValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnFalse()
            ->once();

        $this->featureValidator->shouldReceive('validate')
            ->with($data)
            ->andReturnFalse()
            ->once();

        $this->layerValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([new ValidationError('layers', 'Missing required key: "layers"')])
            ->once();

        $this->featureValidator->shouldReceive('getErrors')
            ->with()
            ->andReturn([new ValidationError('features', 'Missing required key: "features"')])
            ->once();

        $this->assertFalse($validator->validate($data));
        $this->assertCount(count($errors), $validator->getErrors());
        $this->assertEquals($errors, $validator->getErrors());
    }

    private function getInstance(): BlueprintValidator
    {
        return new BlueprintValidator(
            $this->layerValidator,
            $this->featureValidator,
        );
    }
}
