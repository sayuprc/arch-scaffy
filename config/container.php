<?php

declare(strict_types=1);

use ArchScaffy\Ast\AstBuilder;
use ArchScaffy\Ast\AstBuilderInterface;
use ArchScaffy\Ast\AstComponentBuilder;
use ArchScaffy\Ast\AstComponentBuilderInterface;
use ArchScaffy\Ast\Printer\Printer;
use ArchScaffy\Ast\Printer\PrinterInterface;
use ArchScaffy\Blueprint\Feature\Validator\FeatureValidator;
use ArchScaffy\Blueprint\Feature\Validator\FeatureValidatorInterface;
use ArchScaffy\Blueprint\Layer\Validator\LayerValidator;
use ArchScaffy\Blueprint\Layer\Validator\LayerValidatorInterface;
use ArchScaffy\Blueprint\Validator\BlueprintValidator;
use ArchScaffy\Blueprint\Validator\BlueprintValidatorInterface;
use ArchScaffy\Config\Class\Validator\ClassConfigValidator;
use ArchScaffy\Config\Class\Validator\ClassConfigValidatorInterface;
use ArchScaffy\Config\Global\Validator\GlobalConfigValidator;
use ArchScaffy\Config\Global\Validator\GlobalConfigValidatorInterface;
use ArchScaffy\Config\Validator\ConfigValidator;
use ArchScaffy\Config\Validator\ConfigValidatorInterface;
use ArchScaffy\Ir\Converter\IrConverter;
use ArchScaffy\Ir\Converter\IrConverterInterface;
use ArchScaffy\Mapper\Mapper;
use ArchScaffy\Mapper\MapperInterface;
use ArchScaffy\Writer\Writer;
use ArchScaffy\Writer\WriterInterface;
use ArchScaffy\YamlParser\YamlParser;
use ArchScaffy\YamlParser\YamlParserInterface;
use PhpParser\PhpVersion;
use PhpParser\PrettyPrinter\Standard;

use function DI\autowire;

return [
    YamlParserInterface::class => autowire(YamlParser::class),
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
