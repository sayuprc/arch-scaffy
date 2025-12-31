<?php

declare(strict_types=1);

namespace ArchScaffy\Mapper;

use ArchScaffy\Dto\Blueprint\Feature\Component\AbstractClassComponent;
use ArchScaffy\Dto\Blueprint\Feature\Component\ClassComponent;
use ArchScaffy\Dto\Blueprint\Feature\Component\ComponentInterface;
use ArchScaffy\Dto\Blueprint\Feature\Component\InterfaceComponent;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\MapperBuilder;
use DomainException;
use Override;

readonly class Mapper implements MapperInterface
{
    public function __construct(private MapperBuilder $builder)
    {
    }

    #[Override]
    public function map(string $signature, array $source): mixed
    {
        return $this->builder
            ->infer(
                ComponentInterface::class,
                /** @return class-string<ClassComponent|AbstractClassComponent|InterfaceComponent> */
                fn (string $kind, ?bool $abstract = null): string => match ($kind) {
                    'class' => $abstract
                        ? AbstractClassComponent::class
                        : ClassComponent::class,
                    'interface' => InterfaceComponent::class,
                    default => throw new DomainException("Unhandled kind {$kind}")
                }
            )
            ->mapper()
            ->map($signature, Source::array($source));
    }
}
