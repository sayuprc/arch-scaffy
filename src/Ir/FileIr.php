<?php

declare(strict_types=1);

namespace ArchScaffy\Ir;

use ArchScaffy\Ir\Component\ComponentIrInterface;

final readonly class FileIr
{
    public function __construct(
        private string $output,
        public bool $isStrict,
        public string $namespace,
        public ComponentIrInterface $component,
    ) {
    }

    public function getFilePath(): string
    {
        return $this->output . '/' . $this->component->name();
    }
}
