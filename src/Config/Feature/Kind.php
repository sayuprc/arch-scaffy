<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Feature;

enum Kind: string
{
    case ClassKind = 'class';
    case Interface = 'interface';
    case Trait = 'trait';
    case Enum = 'enum';

    public function isClass(): bool
    {
        return $this === self::ClassKind;
    }

    public function isInterface(): bool
    {
        return $this === self::Interface;
    }

    public function isTrait(): bool
    {
        return $this === self::Trait;
    }

    public function isEnum(): bool
    {
        return $this === self::Enum;
    }
}
