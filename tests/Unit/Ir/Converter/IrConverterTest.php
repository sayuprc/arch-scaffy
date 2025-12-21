<?php

declare(strict_types=1);

namespace Tests\Unit\Ir\Converter;

use ArchScaffy\Blueprint\Blueprint;
use ArchScaffy\Blueprint\Feature\Component\AbstractClassComponent;
use ArchScaffy\Blueprint\Feature\Component\ClassComponent;
use ArchScaffy\Blueprint\Feature\Component\InterfaceComponent;
use ArchScaffy\Blueprint\Feature\Feature;
use ArchScaffy\Blueprint\Layer\Layer;
use ArchScaffy\Config\Class\ClassConfig;
use ArchScaffy\Config\Config;
use ArchScaffy\Config\Global\GlobalConfig;
use ArchScaffy\Ir\Component\AbstractClassIr;
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
                'Domain' => new Layer(output: 'app/Domain/{Feature}', namespace: 'App\Domain\{Feature}'),
                'UseCase' => new Layer(output: 'app/UseCase/{Sub}', namespace: 'App\UseCase\{Sub}'),
                'Infrastructure' => new Layer(output: 'app/Infrastructure/{Sub}', namespace: 'App\Infrastructure\{Sub}'),
            ],
            [
                'User' => new Feature([
                    new ClassComponent(name: 'User', layer: 'Domain'),
                    new InterfaceComponent(name: 'UserRepositoryInterface', layer: 'Domain'),
                    new AbstractClassComponent(name: 'AbstractUserRepository', layer: 'Infrastructure'),
                    new ClassComponent(name: 'CreateUseCase', layer: 'UseCase'),
                    new ClassComponent(name: 'DeleteUseCase', layer: 'UseCase', placeholders: ['Sub' => 'Delete']),
                ]),
            ],
        );

        $irs = $this->getInstance()->toFileIrs($config, $blueprint);

        $this->assertCount(1, $irs);
        $this->assertArrayHasKey('User', $irs);
        $this->assertCount(5, $irs['User']);

        $this->assertSame('./app/Domain/User', $irs['User'][0]->output);
        $this->assertSame('App\Domain\User', $irs['User'][0]->namespace);
        $this->assertTrue($irs['User'][0]->isStrict);
        $this->assertInstanceOf(ClassIr::class, $irs['User'][0]->component);

        $this->assertSame('./app/Domain/User', $irs['User'][1]->output);
        $this->assertSame('App\Domain\User', $irs['User'][1]->namespace);
        $this->assertTrue($irs['User'][1]->isStrict);
        $this->assertInstanceOf(InterfaceIr::class, $irs['User'][1]->component);

        $this->assertSame('./app/Infrastructure', $irs['User'][2]->output);
        $this->assertSame('App\Infrastructure', $irs['User'][2]->namespace);
        $this->assertTrue($irs['User'][2]->isStrict);
        $this->assertInstanceOf(AbstractClassIr::class, $irs['User'][2]->component);

        $this->assertSame('./app/UseCase', $irs['User'][3]->output);
        $this->assertSame('App\UseCase', $irs['User'][3]->namespace);
        $this->assertTrue($irs['User'][3]->isStrict);
        $this->assertInstanceOf(ClassIr::class, $irs['User'][3]->component);

        $this->assertSame('./app/UseCase/Delete', $irs['User'][4]->output);
        $this->assertSame('App\UseCase\Delete', $irs['User'][4]->namespace);
        $this->assertTrue($irs['User'][4]->isStrict);
        $this->assertInstanceOf(ClassIr::class, $irs['User'][4]->component);
    }

    private function getInstance(): IrConverter
    {
        return new IrConverter();
    }
}
