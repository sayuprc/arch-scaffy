<?php

declare(strict_types=1);

namespace Tests\Unit\Dto\Config\Global\Validation;

use ArchScaffy\Dto\Config\Global\Validation\GlobalConfigValidator;
use ArchScaffy\Validation\ValidationError;
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
                        'root' => '.',
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
                        'root' => '.',
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
                        'incorrect root' => '.',
                        'incorrect strict' => false,
                    ],
                ],
                'errors' => [
                    new ValidationError('global.root', 'Missing required key: "root"'),
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
