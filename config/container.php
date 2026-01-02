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
use ArchScaffy\Dto\Blueprint\Feature\Validation\FeatureValidator;
use ArchScaffy\Dto\Blueprint\Feature\Validation\FeatureValidatorInterface;
use ArchScaffy\Dto\Blueprint\Layer\Validation\LayerValidator;
use ArchScaffy\Dto\Blueprint\Layer\Validation\LayerValidatorInterface;
use ArchScaffy\Dto\Blueprint\Validation\BlueprintValidator;
use ArchScaffy\Dto\Blueprint\Validation\BlueprintValidatorInterface;
use ArchScaffy\Dto\Config\Class\Validation\ClassConfigValidator;
use ArchScaffy\Dto\Config\Class\Validation\ClassConfigValidatorInterface;
use ArchScaffy\Dto\Config\Global\Validation\GlobalConfigValidator;
use ArchScaffy\Dto\Config\Global\Validation\GlobalConfigValidatorInterface;
use ArchScaffy\Dto\Config\Validation\ConfigValidator;
use ArchScaffy\Dto\Config\Validation\ConfigValidatorInterface;
use ArchScaffy\Mapper\Mapper;
use ArchScaffy\Mapper\MapperInterface;
use ArchScaffy\Parser\ParserInterface;
use ArchScaffy\Parser\Yaml\YamlParser;
use ArchScaffy\Writer\Writer;
use ArchScaffy\Writer\WriterInterface;
use PhpParser\PhpVersion;
use PhpParser\PrettyPrinter\Standard;

use function DI\autowire;

return [
    ParserInterface::class => autowire(YamlParser::class),
    ConfigValidatorInterface::class => autowire(ConfigValidator::class),
    GlobalConfigValidatorInterface::class => autowire(GlobalConfigValidator::class),
    ClassConfigValidatorInterface::class => autowire(ClassConfigValidator::class),
    BlueprintValidatorInterface::class => autowire(BlueprintValidator::class),
    LayerValidatorInterface::class => autowire(LayerValidator::class),
    FeatureValidatorInterface::class => autowire(FeatureValidator::class),
    AstBuilderInterface::class => autowire(AstBuilder::class),
    AstComponentBuilderInterface::class => autowire(AstComponentBuilder::class),
    PrinterInterface::class => autowire(Printer::class),
    MapperInterface::class => autowire(Mapper::class),
    IrConverterInterface::class => autowire(IrConverter::class),
    WriterInterface::class => autowire(Writer::class),
    Standard::class => fn () => new Standard(['phpVersion' => PhpVersion::getHostVersion()]),
];
