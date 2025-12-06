<?php

declare(strict_types=1);

namespace ArchScaffy\Config\Feature;

enum ScaffoldType: string
{
    case Class = 'class';
    case Interface = 'interface';
}
