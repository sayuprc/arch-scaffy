<?php

declare(strict_types=1);

use ArchScaffy\Ast\Builder\AstBuilder;
use ArchScaffy\Ast\Builder\AstBuilderInterface;
use ArchScaffy\Ast\Builder\AstComponentBuilder;
use ArchScaffy\Ast\Builder\AstComponentBuilderInterface;
use ArchScaffy\Ast\Printer\Printer;
use ArchScaffy\Ast\Printer\PrinterInterface;
use ArchScaffy\Converter\IrConverter;
use ArchScaffy\Converter\IrConverterInterface;
use ArchScaffy\Dto\Blueprint\Validator\BlueprintValidator;
use ArchScaffy\Dto\Blueprint\Validator\BlueprintValidatorInterface;
use ArchScaffy\Dto\Config\Validator\ConfigValidator;
use ArchScaffy\Dto\Config\Validator\ConfigValidatorInterface;
use ArchScaffy\Mapper\Mapper;
use ArchScaffy\Mapper\MapperInterface;
use ArchScaffy\Parser\ParserInterface;
use ArchScaffy\Parser\Yaml\YamlParser;
use ArchScaffy\Validator\Validator;
use ArchScaffy\Validator\ValidatorInterface;
use ArchScaffy\Writer\Writer;
use ArchScaffy\Writer\WriterInterface;
use PhpParser\PhpVersion;
use PhpParser\PrettyPrinter\Standard;

use function DI\autowire;

return [
    ParserInterface::class => autowire(YamlParser::class),
    ConfigValidatorInterface::class => autowire(ConfigValidator::class),
    BlueprintValidatorInterface::class => autowire(BlueprintValidator::class),
    ValidatorInterface::class => autowire(Validator::class),
    AstBuilderInterface::class => autowire(AstBuilder::class),
    AstComponentBuilderInterface::class => autowire(AstComponentBuilder::class),
    PrinterInterface::class => autowire(Printer::class),
    MapperInterface::class => autowire(Mapper::class),
    IrConverterInterface::class => autowire(IrConverter::class),
    WriterInterface::class => autowire(Writer::class),
    Standard::class => fn () => new Standard(['phpVersion' => PhpVersion::getHostVersion()]),
];
