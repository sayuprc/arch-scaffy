<?php

declare(strict_types=1);

namespace ArchScaffy\Validator;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\RuleSet\RuleSetCollectionInterface;

interface ValidatorInterface
{
    public function validate(RuleSetCollectionInterface $collection, ValidationContextInterface $context): bool;

    /**
     * @return array<ValidationError>
     */
    public function getErrors(): array;
}
