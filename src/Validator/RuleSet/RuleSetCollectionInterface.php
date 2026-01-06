<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\RuleSet;

interface RuleSetCollectionInterface
{
    /**
     * @return array<RuleSet>
     */
    public function all(): array;
}
