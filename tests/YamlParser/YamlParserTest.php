<?php

declare(strict_types=1);

namespace Tests\YamlParser;

use ArchScaffy\YamlParser\YamlParser;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class YamlParserTest extends TestCase
{
    #[Test]
    public function parseTest(): void
    {
        $result = $this->getInstance()->parseFile(__DIR__ . '/data/sample.yaml');

        $this->assertSame(
            [
                'array' => [
                    'a',
                    'b',
                    'c',
                ],
                'object' => [
                    'list' => [
                        [
                            'name' => 'value 1',
                        ],
                        [
                            'name' => 'value 2',
                        ],
                    ],
                ],
            ],
            $result
        );
    }

    #[Test]
    public function resultIsNotArray(): void
    {
        $file = __DIR__ . '/data/error.yaml';

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage("The parsing result of the YAML file \"{$file}\" was expected to be an array, but it is an string.");

        $this->getInstance()->parseFile($file);
    }

    private function getInstance(): YamlParser
    {
        return new YamlParser();
    }
}
