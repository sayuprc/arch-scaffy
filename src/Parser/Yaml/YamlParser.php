<?php

declare(strict_types=1);

namespace ArchScaffy\Parser\Yaml;

use ArchScaffy\Parser\ParserInterface;
use Override;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

class YamlParser implements ParserInterface
{
    #[Override]
    public function parseFile(string $file): array
    {
        $array = Yaml::parseFile($file);

        if (! is_array($array)) {
            throw new UnexpectedValueException(
                sprintf(
                    'The parsing result of the YAML file "%s" was expected to be an array, but it is an %s.',
                    $file,
                    get_debug_type($array)
                )
            );
        }

        return $array;
    }
}
