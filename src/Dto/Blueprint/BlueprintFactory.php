<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Blueprint;

use ArchScaffy\Dto\Blueprint\Validator\BlueprintValidatorInterface;
use ArchScaffy\Mapper\MapperInterface;
use ArchScaffy\Parser\ParserInterface;
use ArchScaffy\Validator\Context\ValidationContext;
use ArchScaffy\Validator\ValidationError;
use ResultType\Eager\Err;
use ResultType\Eager\Ok;
use ResultType\Result;

final readonly class BlueprintFactory
{
    public function __construct(
        private ParserInterface $parser,
        private BlueprintValidatorInterface $validator,
        private MapperInterface $mapper,
    ) {
    }

    /**
     * @return Result<Blueprint, array<ValidationError>>
     */
    public function create(string $file): Result
    {
        $data = $this->parser->parseFile($file);

        if (! $this->validator->validate(new ValidationContext($data))) {
            return new Err($this->validator->getErrors());
        }

        $blueprint = $this->mapper->map(Blueprint::class, $data);

        return new Ok($blueprint);
    }
}
