<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint\Feature;

class Property
{
    public function __construct(
        public string $name,
        public string $type,
        public bool $isStatic,
        public bool $isAbstract,
        public bool $isFinal,
    ) {
    }
}
