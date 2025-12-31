<?php

declare(strict_types=1);

namespace ArchScaffy\Converter;

use ArchScaffy\Dto\Blueprint\Blueprint;
use ArchScaffy\Dto\Config\Config;
use ArchScaffy\Ir\FileIr;

interface IrConverterInterface
{
    /**
     * @return array<string, array<FileIr>>
     */
    public function toFileIrs(Config $config, Blueprint $blueprint): array;
}
