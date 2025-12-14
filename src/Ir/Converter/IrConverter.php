<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Converter;

use ArchScaffy\Blueprint\Blueprint;
use ArchScaffy\Blueprint\Feature\Component;
use ArchScaffy\Blueprint\Feature\Kind;
use ArchScaffy\Config\Config;
use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;
use ArchScaffy\Ir\FileIr;
use Override;

final readonly class IrConverter implements IrConverterInterface
{
    #[Override]
    public function toFileIrs(Config $config, Blueprint $blueprint): array
    {
        $fileIrs = [];

        foreach ($blueprint->features as $feature) {
            foreach ($feature->components as $component) {
                $layer = $blueprint->getLayer($component->layer);

                $fileIrs[] = new FileIr(
                    $layer->output,
                    $config->global->strict,
                    $layer->namespace,
                    match ($component->kind) {
                        Kind::ClassKind => $this->toClass($component),
                        Kind::Interface => $this->toInterface($component),
                    },
                );
            }
        }

        return $fileIrs;
    }

    private function toClass(Component $component): ClassIr
    {
        return new ClassIr($component->name);
    }

    private function toInterface(Component $component): InterfaceIr
    {
        return new InterfaceIr($component->name);
    }
}
