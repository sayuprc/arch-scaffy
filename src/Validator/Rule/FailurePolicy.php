<?php

declare(strict_types=1);

namespace ArchScaffy\Validator\Rule;

enum FailurePolicy
{
    case Continue;
    case Abort;

    public function shouldAbort(): bool
    {
        return $this === self::Abort;
    }
}
