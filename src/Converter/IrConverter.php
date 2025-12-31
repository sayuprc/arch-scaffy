<?php

declare(strict_types=1);

namespace ArchScaffy\Converter;

use ArchScaffy\Dto\Blueprint\Blueprint;
use ArchScaffy\Dto\Blueprint\Feature\Component\ClassComponent;
use ArchScaffy\Dto\Blueprint\Feature\Component\ComponentInterface;
use ArchScaffy\Dto\Blueprint\Feature\Component\InterfaceComponent;
use ArchScaffy\Dto\Blueprint\Layer\Layer;
use ArchScaffy\Dto\Config\Config;
use ArchScaffy\Ir\Class\AbstractClassIr;
use ArchScaffy\Ir\Class\ClassIr;
use ArchScaffy\Ir\Class\ClassIrInterface;
use ArchScaffy\Ir\Class\InterfaceIr;
use ArchScaffy\Ir\FileIr;
use Override;

final readonly class IrConverter implements IrConverterInterface
{
    private const string FEATURE_PLACEHOLDER = '{Feature}';

    #[Override]
    public function toFileIrs(Config $config, Blueprint $blueprint): array
    {
        $fileIrs = [];

        foreach ($blueprint->features as $name => $feature) {
            foreach ($feature->components as $component) {
                $layer = $blueprint->getLayer($component->layer);

                $fileIrs[$name][] = new FileIr(
                    $config->global->root . '/' . $this->resolveOutput($layer, $name, $component),
                    $config->global->strict,
                    $this->resolveNamespace($layer, $name, $component),
                    match (true) {
                        $component instanceof ClassComponent => $this->toClass($config, $component),
                        $component instanceof InterfaceComponent => $this->toInterface($component),
                    },
                );
            }
        }

        return $fileIrs;
    }

    private function resolveOutput(Layer $layer, string $featureName, ComponentInterface $component): string
    {
        return rtrim($this->resolveTemplate($layer->output, $featureName, $component), '/');
    }

    private function resolveNamespace(Layer $layer, string $featureName, ComponentInterface $component): string
    {
        return rtrim($this->resolveTemplate($layer->namespace, $featureName, $component), '\\');
    }

    private function resolveTemplate(string $template, string $featureName, ComponentInterface $component): string
    {
        return (string)preg_replace(
            '/{\w+}/',
            '',
            $this->resolvePlaceholders(
                $this->resolveFeature($template, $featureName),
                $component
            )
        );
    }

    private function resolveFeature(string $template, string $featureName): string
    {
        return str_replace(self::FEATURE_PLACEHOLDER, $featureName, $template);
    }

    private function resolvePlaceholders(string $template, ComponentInterface $component): string
    {
        foreach ($component->placeholders as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }

    private function toClass(Config $config, ClassComponent $component): ClassIrInterface
    {
        $isReadonly = $component->readonly ?? $config->class->readonly;

        return $component->abstract
            ? new AbstractClassIr(
                $component->name,
                $isReadonly
            )
            : new ClassIr(
                $component->name,
                $component->final ?? $config->class->final,
                $isReadonly
            );
    }

    private function toInterface(InterfaceComponent $component): InterfaceIr
    {
        return new InterfaceIr($component->name);
    }
}
