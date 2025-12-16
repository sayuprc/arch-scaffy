<?php

declare(strict_types=1);

namespace Tests\Unit\Writer;

use ArchScaffy\Writer\Writer;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WriteTest extends TestCase
{
    #[Test]
    public function writeTest(): void
    {
        $file = __DIR__ . '/write-test.txt';

        if (file_exists($file)) {
            @unlink($file);
        }

        $this->getInstance()->write('test data', $file);

        $this->assertTrue(file_exists($file));
        $this->assertSame('test data', file_get_contents($file));

        @unlink($file);
    }

    private function getInstance(): Writer
    {
        return new Writer();
    }
}
