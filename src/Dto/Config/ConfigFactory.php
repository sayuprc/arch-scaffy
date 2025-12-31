<?php

declare(strict_types=1);

namespace ArchScaffy\Dto\Config;

use ArchScaffy\Dto\Config\Validator\ConfigValidatorInterface;
use ArchScaffy\Mapper\MapperInterface;
use ArchScaffy\Parser\ParserInterface;
use ArchScaffy\Validator\ValidationError;
use ResultType\Eager\Err;
use ResultType\Eager\Ok;
use ResultType\Result;

final readonly class ConfigFactory
{
    public function __construct(
        private ParserInterface $parser,
        private ConfigValidatorInterface $validator,
        private MapperInterface $mapper,
    ) {
    }

    /**
     * @return Result<Config, array<ValidationError>>
     */
    public function create(string $file): Result
    {
        $data = $this->parser->parseFile($file);

        if (! $this->validator->validate($data)) {
            return new Err($this->validator->getErrors());
        }

        $config = $this->mapper->map(Config::class, $data);

        return new Ok($config);
    }
}
