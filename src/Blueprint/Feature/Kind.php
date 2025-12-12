<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature;

enum Kind: string
{
    case ClassKind = 'class';
    case Interface = 'interface';
}
