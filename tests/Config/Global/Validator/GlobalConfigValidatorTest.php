<?php

declare(strict_types=1);

namespace Tests\Config\Global\Validator;

use ArchScaffy\Config\Global\Validator\GlobalConfigValidator;
use ArchScaffy\Validator\ValidationError;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GlobalConfigValidatorTest extends TestCase
{
    #[Test]
    #[DataProvider('correctGlobalConfigDataProvider')]
    public function correctGlobalConfig(array $data): void
    {
        $validator = $this->getInstance();

        $this->assertTrue($validator->validate($data));
    }

    public static function correctGlobalConfigDataProvider(): array
    {
        return [
            'correct global' => [
                [
                    'global' => [
                        'strict' => true,
                    ],
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('incorrectGlobalConfigDataProvider')]
    public function incorrectGlobalConfig(array $data, array $errors): void
    {
        $validator = $this->getInstance();

        $this->assertFalse($validator->validate($data));
        $this->assertCount(count($errors), $validator->getErrors());
        $this->assertEquals($errors, $validator->getErrors());
    }

    public static function incorrectGlobalConfigDataProvider(): array
    {
        return [
            'global does not exists' => [
                'data' => [
                    'incorrect global' => [
                        'strict' => false,
                    ],
                ],
                'errors' => [
                    new ValidationError('global', 'Missing required key: "global"'),
                ],
            ],
            'type of global is incorrect' => [
                'data' => [
                    'global' => '',
                ],
                'errors' => [
                    new ValidationError('global', 'Invalid type for key "global": expected array got string'),
                ],
            ],
            'strict does not exists' => [
                'data' => [
                    'global' => [
                        'incorrect strict' => false,
                    ],
                ],
                'errors' => [
                    new ValidationError('global.strict', 'Missing required key: "strict"'),
                ],
            ],
        ];
    }

    private function getInstance(): GlobalConfigValidator
    {
        return new GlobalConfigValidator();
    }
}
