<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Converter;

use ArchScaffy\Blueprint\Blueprint;
use ArchScaffy\Blueprint\Feature\Component;
use ArchScaffy\Blueprint\Feature\Kind;
use ArchScaffy\Blueprint\Layer\Layer;
use ArchScaffy\Config\Config;
use ArchScaffy\Ir\Component\ClassIr;
use ArchScaffy\Ir\Component\InterfaceIr;
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
                    match ($component->kind) {
                        Kind::ClassKind => $this->toClass($config, $component),
                        Kind::Interface => $this->toInterface($component),
                    },
                );
            }
        }

        return $fileIrs;
    }

    private function resolveOutput(Layer $layer, string $featureName, Component $component): string
    {
        return rtrim($this->resolveTemplate($layer->output, $featureName, $component), '/');
    }

    private function resolveNamespace(Layer $layer, string $featureName, Component $component): string
    {
        return rtrim($this->resolveTemplate($layer->namespace, $featureName, $component), '\\');
    }

    private function resolveTemplate(string $template, string $featureName, Component $component): string
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

    private function resolvePlaceholders(string $template, Component $component): string
    {
        foreach ($component->placeholders as $key => $value) {
            $template = str_replace("{{$key}}", $value, $template);
        }

        return $template;
    }

    private function toClass(Config $config, Component $component): ClassIr
    {
        return new ClassIr(
            $component->name,
            $config->class->final,
            $config->class->readonly
        );
    }

    private function toInterface(Component $component): InterfaceIr
    {
        return new InterfaceIr($component->name);
    }
}
