<?php

declare(strict_types=1);

namespace ArchScaffy\Command;

use ArchScaffy\Ast\AstBuilderInterface;
use ArchScaffy\Ast\Printer\PrinterInterface;
use ArchScaffy\Blueprint\BlueprintFactory;
use ArchScaffy\Config\ConfigFactory;
use ArchScaffy\Ir\Converter\IrConverterInterface;
use ArchScaffy\Writer\WriterInterface;
use PhpParser\Node;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate',
    description: 'Generate code based on the design file.'
)]
final class GenerateCommand extends Command
{
    /**
     * @param AstBuilderInterface<array<Node>> $astBuilder
     * @param PrinterInterface<Node>           $printer
     */
    public function __construct(
        private ConfigFactory $configFactory,
        private BlueprintFactory $blueprintFactory,
        private IrConverterInterface $irConverter,
        private AstBuilderInterface $astBuilder,
        private PrinterInterface $printer,
        private WriterInterface $writer,
    ) {
        parent::__construct();
    }

    public function __invoke(OutputInterface $output): int
    {
        $configFile = getcwd() . '/scaffy.config.yaml';
        if (! file_exists($configFile)) {
            $output->writeln(sprintf('The file %s could not be found.', $configFile));

            return Command::FAILURE;
        }

        $blueprintfFile = getcwd() . '/scaffy.blueprint.yaml';
        if (! file_exists($blueprintfFile)) {
            $output->writeln(sprintf('The file %s could not be found.', $blueprintfFile));

            return Command::FAILURE;
        }

        $configResult = $this->configFactory->create($configFile);
        if ($configResult->isErr()) {
            foreach ($configResult->unwrapErr() as $error) {
                $output->writeln(sprintf('%s(%s)', $error->message, $error->path));
            }

            return Command::FAILURE;
        }

        $blueprintResult = $this->blueprintFactory->create($blueprintfFile);
        if ($blueprintResult->isErr()) {
            foreach ($blueprintResult->unwrapErr() as $error) {
                $output->writeln(sprintf('%s(%s)', $error->message, $error->path));
            }

            return Command::FAILURE;
        }

        $irs = $this->irConverter->toFileIrs($configResult->unwrap(), $blueprintResult->unwrap());

        foreach ($irs as $ir) {
            if (file_exists($outputPath = sprintf('%s/%s', getcwd(), $ir->output))) {
                $output->writeln(sprintf('Generation is skipped since a corresponding output destination already exists: %s', $outputPath));

                continue;
            }

            $filePath = sprintf('%s/%s', getcwd(), $ir->getFilePath());

            $dir = dirname($filePath);
            if (! is_dir($dir)) {
                mkdir(directory: $dir, recursive: true);
            }

            $this->writer->write(
                $this->printer->print($this->astBuilder->build($ir)),
                $filePath,
            );

            $output->writeln(sprintf('Created: %s', $filePath));
        }

        return Command::SUCCESS;
    }
}
