<?php

declare(strict_types=1);

namespace ArchScaffy\Validator;

use ArchScaffy\Validator\Context\ValidationContextInterface;
use ArchScaffy\Validator\RuleSet\RuleSet;
use ArchScaffy\Validator\RuleSet\RuleSetCollectionInterface;
use Generator;
use Override;

final class Validator implements ValidatorInterface
{
    /**
     * @var array<ValidationError>
     */
    private array $errors = [];

    #[Override]
    public function validate(RuleSetCollectionInterface $collection, ValidationContextInterface $context): bool
    {
        foreach ($collection->all() as $ruleSet) {
            foreach ($this->getIterableValidationContext($ruleSet, $context) as $key => $value) {
                foreach ($ruleSet->rules as $rule) {
                    $messages = $rule->validate($value, $key, $context);

                    if (count($messages) === 0) {
                        continue;
                    }

                    $this->addError($key, $messages);

                    if ($rule->failurePolicy()->shouldAbort()) {
                        break;
                    }
                }
            }
        }

        return count($this->errors) === 0;
    }

    /**
     * @return Generator<string, mixed>
     */
    private function getIterableValidationContext(RuleSet $ruleSet, ValidationContextInterface $context): Generator
    {
        $key = $ruleSet->key;

        return $ruleSet->hasWildcard()
            ? $context->resolveWildcard($key)
            : (fn (): Generator => yield $key => $context->get($key))();
    }

    /**
     * @param array<string> $messages
     */
    private function addError(string $key, array $messages): void
    {
        foreach ($messages as $message) {
            $this->errors[] = new ValidationError($key, $message);
        }
    }

    #[Override]
    public function getErrors(): array
    {
        return $this->errors;
    }
}
