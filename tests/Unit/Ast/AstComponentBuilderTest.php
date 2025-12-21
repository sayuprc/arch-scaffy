<?php

declare(strict_types=1);

namespace Tests\Unit\Ast;

use ArchScaffy\Ast\AstComponentBuilder;
use ArchScaffy\Ir\Component\ClassIr;
use Mockery;
use Mockery\MockInterface;
use PhpParser\Builder\Class_;
use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt\Class_ as StmtClass_;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AstComponentBuilderTest extends TestCase
{
    private BuilderFactory&MockInterface $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = Mockery::mock(BuilderFactory::class);
    }

    #[Test]
    #[DataProvider('buildClassDataProvider')]
    public function buildClass(ClassIr $ir): void
    {
        $this->factory->shouldReceive('class')
            ->with($ir->name)
            ->andReturn(new Class_($ir->name))
            ->once();

        $node = $this->getInstance()->buildClass($ir);

        $this->assertInstanceOf(StmtClass_::class, $node);
        assert($node instanceof StmtClass_);
        $this->assertSame($ir->name, $node->name->name);
        $this->assertSame($ir->isFinal, $node->isFinal());
        $this->assertSame($ir->isReadonly, $node->isReadonly());
        $this->assertSame($ir->isAbstract, $node->isAbstract());
    }

    public static function buildClassDataProvider(): array
    {
        return [
            'non-final non-readonly class' => [new ClassIr(name: 'A', isFinal: false, isReadonly: false, isAbstract: false)],
            'final class' => [new ClassIr(name: 'B', isFinal: true, isReadonly: false, isAbstract: false)],
            'readonly class' => [new ClassIr(name: 'C', isFinal: false, isReadonly: true, isAbstract: false)],
            'final readonly class' => [new ClassIr(name: 'D', isFinal: true, isReadonly: true, isAbstract: false)],
            'abstract class' => [new ClassIr(name: 'E', isFinal: false, isReadonly: false, isAbstract: true)],
            'readonly abstract class' => [new ClassIr(name: 'F', isFinal: false, isReadonly: true, isAbstract: true)],
        ];
    }

    private function getInstance(): AstComponentBuilder
    {
        return new AstComponentBuilder($this->factory);
    }
}
