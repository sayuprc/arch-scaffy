<?php

declare(strict_types=1);

namespace Tests\Unit\Blueprint\Feature\Validator;

use ArchScaffy\Blueprint\Feature\Validator\FeatureValidator;
use ArchScaffy\Validator\ValidationError;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FeatureValidatorTest extends TestCase
{
    #[Test]
    #[DataProvider('correctFeatureDataProvider')]
    public function correctFeature(array $data): void
    {
        $validator = $this->getInstance();

        $this->assertTrue($validator->validate($data));
    }

    public static function correctFeatureDataProvider(): array
    {
        return [
            'correct features' => [
                [
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
                ],
            ],
            'multiple features and components' => [
                [
                    'features' => [
                        'User' => [
                            'components' => [
                                [
                                    'name' => 'UserId',
                                    'layer' => 'Domain',
                                    'kind' => 'class',
                                ],
                                [
                                    'name' => 'UserRepositoryInterface',
                                    'layer' => 'Domain',
                                    'kind' => 'interface',
                                ],
                                [
                                    'name' => 'UserFactory',
                                    'layer' => 'Infrastructure',
                                    'kind' => 'class',
                                ],
                            ],
                        ],
                        'Product' => [
                            'components' => [
                                [
                                    'name' => 'ProductId',
                                    'layer' => 'Domain',
                                    'kind' => 'class',
                                ],
                                [
                                    'name' => 'ProductRepositoryInterface',
                                    'layer' => 'Domain',
                                    'kind' => 'interface',
                                ],
                                [
                                    'name' => 'ProductFactory',
                                    'layer' => 'Infrastructure',
                                    'kind' => 'class',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('incorrectFeatureDataProvider')]
    public function incorrectFeature(array $data, array $errors): void
    {
        $validator = $this->getInstance();

        $this->assertFalse($validator->validate($data));
        $this->assertCount(count($errors), $validator->getErrors());
        $this->assertEquals($errors, $validator->getErrors());
    }

    public static function incorrectFeatureDataProvider(): array
    {
        return [
            'features does not exists' => [
                'data' => [
                    'incorrect features' => [
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
                ],
                'errors' => [
                    new ValidationError('features', 'Missing required key: "features"'),
                ],
            ],
            'type of features is incorrect' => [
                'data' => [
                    'features' => '',
                ],
                'errors' => [
                    new ValidationError('features', 'Invalid type for key "features": expected array got string'),
                ],
            ],
            'type of User is incorrect' => [
                'data' => [
                    'features' => [
                        'User' => '',
                    ],
                ],
                'errors' => [
                    new ValidationError('features.User', 'Invalid type for key "User": expected array got string'),
                ],
            ],
            'components does not exists' => [
                'data' => [
                    'features' => [
                        'User' => [
                            'incorrect components' => [
                                [
                                    'name' => 'UserId',
                                    'layer' => 'Domain',
                                    'kind' => 'class',
                                ],
                            ],
                        ],
                    ],
                ],
                'errors' => [
                    new ValidationError('features.User.components', 'Missing required key: "components"'),
                ],
            ],
            'type of components is incorrect' => [
                'data' => [
                    'features' => [
                        'User' => [
                            'components' => '',
                        ],
                    ],
                ],
                'errors' => [
                    new ValidationError('features.User.components', 'Invalid type for key "components": expected array got string'),
                ],
            ],
            'type of components elements are incorrect' => [
                'data' => [
                    'features' => [
                        'User' => [
                            'components' => [
                                '',
                            ],
                        ],
                    ],
                ],
                'errors' => [
                    new ValidationError('features.User.components.0', 'Invalid type for key "components": expected array got string'),
                ],
            ],
            'components elements are do not exists' => [
                'data' => [
                    'features' => [
                        'User' => [
                            'components' => [
                                [
                                    'incorrect name' => 'UserId',
                                    'incorrect layer' => 'Domain',
                                    'incorrect kind' => 'class',
                                ],
                                [
                                    'name' => 'UserId',
                                    'layer' => 'Domain',
                                    'kind' => 'class',
                                ],
                                [
                                    'incorrect name' => 'UserId',
                                    'incorrect layer' => 'Domain',
                                    'incorrect kind' => 'class',
                                ],
                            ],
                        ],
                    ],
                ],
                'errors' => [
                    new ValidationError('features.User.components.0.name', 'Missing required key: "name"'),
                    new ValidationError('features.User.components.0.layer', 'Missing required key: "layer"'),
                    new ValidationError('features.User.components.0.kind', 'Missing required key: "kind"'),

                    new ValidationError('features.User.components.2.name', 'Missing required key: "name"'),
                    new ValidationError('features.User.components.2.layer', 'Missing required key: "layer"'),
                    new ValidationError('features.User.components.2.kind', 'Missing required key: "kind"'),
                ],
            ],
        ];
    }

    private function getInstance(): FeatureValidator
    {
        return new FeatureValidator();
    }
}
