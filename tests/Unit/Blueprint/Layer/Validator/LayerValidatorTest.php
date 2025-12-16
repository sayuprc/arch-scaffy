<?php

declare(strict_types=1);

namespace Tests\Unit\Blueprint\Layer\Validator;

use ArchScaffy\Blueprint\Layer\Validator\LayerValidator;
use ArchScaffy\Validator\ValidationError;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LayerValidatorTest extends TestCase
{
    #[Test]
    #[DataProvider('correctLayerDataProvider')]
    public function correctLayer(array $data): void
    {
        $validator = $this->getInstance();

        $this->assertTrue($validator->validate($data));
    }

    public static function correctLayerDataProvider(): array
    {
        return [
            'correct layers' => [
                [
                    'layers' => [
                        'Domain' => [
                            'output' => 'app/Domain',
                            'namespace' => 'App\Domain',
                        ],
                    ],
                ],
            ],
            'multiple layers' => [
                [
                    'layers' => [
                        'Domain' => [
                            'output' => 'app/Domain',
                            'namespace' => 'App\Domain',
                        ],
                        'UseCase' => [
                            'output' => 'app/UseCase',
                            'namespace' => 'App\UseCase',
                        ],
                    ],
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('incorrectLayerDataProvider')]
    public function incorrectLayer(array $data, array $errors): void
    {
        $validator = $this->getInstance();

        $this->assertFalse($validator->validate($data));
        $this->assertCount(count($errors), $validator->getErrors());
        $this->assertEquals($errors, $validator->getErrors());
    }

    public static function incorrectLayerDataProvider(): array
    {
        return [
            'layers does not exists' => [
                'data' => [
                    'incorrect layers' => [
                        'Domain' => [
                            'output' => 'app/Domain',
                            'namespace' => 'App\Domain',
                        ],
                    ],
                ],
                'errors' => [
                    new ValidationError('layers', 'Missing required key: "layers"'),
                ],
            ],
            'type of layers is incorrect' => [
                'data' => [
                    'layers' => '',
                ],
                'errors' => [
                    new ValidationError('layers', 'Invalid type for key "layers": expected array got string'),
                ],
            ],
            'output and namespace are do not exists' => [
                'data' => [
                    'layers' => [
                        'Domain' => [
                            'incorrect output' => 'app/Domain',
                            'incorrect namespace' => 'App\Domain',
                        ],
                    ],
                ],
                'errors' => [
                    new ValidationError('layers.Domain.output', 'Missing required key: "output"'),
                    new ValidationError('layers.Domain.namespace', 'Missing required key: "namespace"'),
                ],
            ],
        ];
    }

    private function getInstance(): LayerValidator
    {
        return new LayerValidator();
    }
}
