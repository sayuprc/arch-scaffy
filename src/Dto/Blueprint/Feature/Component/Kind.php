<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint\Feature\Component;

enum Kind: string
{
    case Class_ = 'class';
    case Interface_ = 'interface';
}
