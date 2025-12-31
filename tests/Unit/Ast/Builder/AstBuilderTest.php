<?php

declare(strict_types=1);

namespace Tests\Unit\Ast\Builder;

use ArchScaffy\Ast\Builder\AstBuilder;
use ArchScaffy\Ast\Builder\AstComponentBuilderInterface;
use ArchScaffy\Ir\Class\ClassIr;
use ArchScaffy\Ir\FileIr;
use Mockery;
use Mockery\MockInterface;
use PhpParser\Builder\Class_;
use PhpParser\Node\Scalar\Int_;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Nop;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AstBuilderTest extends TestCase
{
    private AstComponentBuilderInterface&MockInterface $astComponentBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->astComponentBuilder = Mockery::mock(AstComponentBuilderInterface::class);
    }

    #[Test]
    public function buildWithoutStrict(): void
    {
        $file = new FileIr(
            output: 'app/Domain',
            isStrict: false,
            namespace: 'App\Domain',
            component: new ClassIr('A', false, false, false),
        );

        $this->astComponentBuilder->shouldReceive('buildClass')
            ->with($this->equalTo($file->component))
            ->andReturn(new Class_($file->component->name()))
            ->once();

        $nodes = $this->getInstance()->build($file);

        $this->assertCount(2, $nodes);

        $this->assertInstanceOf(Namespace_::class, $nodes[0]);
        assert($nodes[0] instanceof Namespace_);
        $this->assertSame($file->namespace, $nodes[0]->name->name);
    }

    #[Test]
    public function buildWithStrict(): void
    {
        $file = new FileIr(
            output: 'app/Domain',
            isStrict: true,
            namespace: 'App\Domain',
            component: new ClassIr('A', false, false, false),
        );

        $this->astComponentBuilder->shouldReceive('buildClass')
            ->with($this->equalTo($file->component))
            ->andReturn(new Class_($file->component->name()))
            ->once();

        $nodes = $this->getInstance()->build($file);

        $this->assertCount(4, $nodes);

        $this->assertInstanceOf(Declare_::class, $nodes[0]);
        assert($nodes[0] instanceof Declare_);
        $this->assertCount(1, $nodes[0]->declares);
        $this->assertSame('strict_types', $nodes[0]->declares[0]->key->name);
        $this->assertInstanceOf(Int_::class, $nodes[0]->declares[0]->value);
        assert($nodes[0]->declares[0]->value instanceof Int_);
        $this->assertSame(1, $nodes[0]->declares[0]->value->value);

        $this->assertInstanceOf(Nop::class, $nodes[1]);

        $this->assertInstanceOf(Namespace_::class, $nodes[2]);
        assert($nodes[2] instanceof Namespace_);
        $this->assertSame($file->namespace, $nodes[2]->name->name);
    }

    private function getInstance(): AstBuilder
    {
        return new AstBuilder($this->astComponentBuilder);
    }
}
