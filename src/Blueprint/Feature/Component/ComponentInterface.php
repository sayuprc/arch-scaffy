<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature\Component;

/**
 * @phpstan-sealed ClassComponent|AbstractClassComponent|InterfaceComponent
 */
interface ComponentInterface
{
    public string $layer { get; }

    /**
     * @var array<string, string>
     */
    public array $placeholders { get; }
}
