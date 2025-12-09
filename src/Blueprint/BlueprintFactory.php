<?php

declare(strict_types=1);

namespace ArchScaffy\Blueprint;

use ArchScaffy\Blueprint\Validator\BlueprintValidatorInterface;
use ArchScaffy\Mapper\MapperInterface;
use ArchScaffy\Validator\ValidationError;
use ArchScaffy\YamlParser\YamlParserInterface;
use ResultType\Eager\Err;
use ResultType\Eager\Ok;
use ResultType\Result;

final readonly class BlueprintFactory
{
    public function __construct(
        private YamlParserInterface $parser,
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

        if (! $this->validator->validate($data)) {
            return new Err($this->validator->getErrors());
        }

        $blueprint = $this->mapper->map(Blueprint::class, $data);

        return new Ok($blueprint);
    }
}
