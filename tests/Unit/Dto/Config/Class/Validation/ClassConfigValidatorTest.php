<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Config\Class\Validation;

use ArchScaffy\Dto\Config\Class\Validation\ClassConfigValidator;
use ArchScaffy\Validation\ValidationError;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClassConfigValidatorTest extends TestCase
{
    #[Test]
    #[DataProvider('correctClassConfigDataProvider')]
    public function correctClassConfig(array $data): void
    {
        $validator = $this->getInstance();

        $this->assertTrue($validator->validate($data));
    }

    public static function correctClassConfigDataProvider(): array
    {
        return [
            'correct class' => [
                [
                    'class' => [
                        'final' => true,
                        'readonly' => true,
                    ],
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('incorrectClassConfigDataProvider')]
    public function incorrectClassConfig(array $data, array $errors): void
    {
        $validator = $this->getInstance();

        $this->assertFalse($validator->validate($data));
        $this->assertCount(count($errors), $validator->getErrors());
        $this->assertEquals($errors, $validator->getErrors());
    }

    public static function incorrectClassConfigDataProvider(): array
    {
        return [
            'class does not exists' => [
                'data' => [
                    'incorrect class' => [
                        'final' => false,
                        'readonly' => true,
                    ],
                ],
                'errors' => [
                    new ValidationError('class', 'Missing required key: "class"'),
                ],
            ],
            'type of class is incorrect' => [
                'data' => [
                    'class' => '',
                ],
                'errors' => [
                    new ValidationError('class', 'Invalid type for key "class": expected array got string'),
                ],
            ],
            'final and readonly are do not exists' => [
                'data' => [
                    'class' => [
                        'incorrect final' => false,
                        'incorrect readonly' => true,
                    ],
                ],
                'errors' => [
                    new ValidationError('class.final', 'Missing required key: "final"'),
                    new ValidationError('class.readonly', 'Missing required key: "readonly"'),
                ],
            ],
        ];
    }

    private function getInstance(): ClassConfigValidator
    {
        return new ClassConfigValidator();
    }
}
