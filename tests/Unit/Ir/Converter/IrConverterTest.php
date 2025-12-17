<?php

declare(strict_types=1);

namespace Tests\Unit\Ir\Converter;

use ArchScaffy\Blueprint\Blueprint;
use ArchScaffy\Blueprint\Feature\Component;
use ArchScaffy\Blueprint\Feature\Feature;
use ArchScaffy\Blueprint\Feature\Kind;
use ArchScaffy\Blueprint\Layer\Layer;
use ArchScaffy\Config\Class\ClassConfig;
use ArchScaffy\Config\Config;
use ArchScaffy\Config\Global\GlobalConfig;
use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;
use ArchScaffy\Ir\Converter\IrConverter;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IrConverterTest extends TestCase
{
    #[Test]
    public function convertToIr(): void
    {
        $config = new Config(new GlobalConfig(root: '.', strict: true), new ClassConfig(final: true, readonly: true));
        $blueprint = new Blueprint(
            [
                'Domain' => new Layer(output: 'app/Domain', namespace: 'App\Domain'),
                'UseCase' => new Layer(output: 'app/UseCase', namespace: 'App\UseCase'),
            ],
            [
                'User' => new Feature([
                    new Component(name: 'User', layer: 'Domain', kind: Kind::ClassKind),
                    new Component(name: 'UserRepositoryInterface', layer: 'Domain', kind: Kind::Interface),
                    new Component(name: 'CreateUseCase', layer: 'UseCase', kind: Kind::ClassKind),
                ]),
            ],
        );

        $irs = $this->getInstance()->toFileIrs($config, $blueprint);

        $this->assertCount(1, $irs);
        $this->assertArrayHasKey('User', $irs);
        $this->assertCount(3, $irs['User']);

        $this->assertSame('app/Domain', $irs['User'][0]->output);
        $this->assertSame('App\Domain', $irs['User'][0]->namespace);
        $this->assertTrue($irs['User'][0]->isStrict);
        $this->assertInstanceOf(ClassIr::class, $irs['User'][0]->component);

        $this->assertSame('app/Domain', $irs['User'][1]->output);
        $this->assertSame('App\Domain', $irs['User'][1]->namespace);
        $this->assertTrue($irs['User'][1]->isStrict);
        $this->assertInstanceOf(InterfaceIr::class, $irs['User'][1]->component);

        $this->assertSame('app/UseCase', $irs['User'][2]->output);
        $this->assertSame('App\UseCase', $irs['User'][2]->namespace);
        $this->assertTrue($irs['User'][2]->isStrict);
        $this->assertInstanceOf(ClassIr::class, $irs['User'][2]->component);
    }

    private function getInstance(): IrConverter
    {
        return new IrConverter();
    }
}
