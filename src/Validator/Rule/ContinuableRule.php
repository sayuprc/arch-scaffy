<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule;

use Override;

trait ContinuableRule
{
    #[Override]
    public function failurePolicy(): FailurePolicy
    {
        return FailurePolicy::Continue;
    }
}
