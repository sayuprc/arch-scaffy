<?php

declare(strict_types=1);

namespace ArchScaffy\Ir\Converter;

use ArchScaffy\Blueprint\Blueprint;
use ArchScaffy\Config\Config;
use ArchScaffy\Ir\FileIr;

interface IrConverterInterface
{
    /**
     * @return array<string, array<FileIr>>
     */
    public function toFileIrs(Config $config, Blueprint $blueprint): array;
}
