<?php

declare(strict_types=1);

namespace ArchScaffy\Command;

use ArchScaffy\Ast\Builder\AstBuilderInterface;
use ArchScaffy\Ast\Printer\PrinterInterface;
use ArchScaffy\Converter\IrConverterInterface;
use ArchScaffy\Dto\Blueprint\BlueprintFactory;
use ArchScaffy\Dto\Config\ConfigFactory;
use ArchScaffy\Writer\WriterInterface;
use Override;
use PhpParser\Node;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'generate',
    description: 'Generate code based on the design file.'
)]
final class GenerateCommand extends Command
{
    /**
     * @var array<array{string, string, int, string, string}>
     */
    private const array OPTIONALS = [
        [
            'config',
            'c',
            InputOption::VALUE_OPTIONAL,
            'Path to config file',
            'scaffy.config.yaml',
        ],
        [
            'blueprint',
            'b',
            InputOption::VALUE_OPTIONAL,
            'Path to blueprint file',
            'scaffy.blueprint.yaml',
        ],
    ];

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

    #[Override]
    protected function configure(): void
    {
        foreach (self::OPTIONALS as [$name, $shourtcut, $mode, $description, $default]) {
            $this->addOption(
                name: $name,
                shortcut: $shourtcut,
                mode: $mode,
                description: $description,
                default: $default
            );
        }
    }

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        $configFile = $input->getOption('config');
        assert(is_string($configFile));
        if (! file_exists($configFile)) {
            $output->writeln(sprintf('The file %s could not be found.', $configFile));

            return Command::FAILURE;
        }

        $blueprintfFile = $input->getOption('blueprint');
        assert(is_string($blueprintfFile));
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

        foreach ($irs as $files) {
            $shouldSkip = false;

            foreach ($files as $file) {
                if ($shouldSkip || file_exists($file->output)) {
                    $shouldSkip = true;

                    $output->writeln(
                        sprintf(
                            'Generation is skipped since a corresponding output destination already exists: %s',
                            $file->getFilePath(),
                        )
                    );
                }
            }

            if ($shouldSkip) {
                continue;
            }

            foreach ($files as $file) {
                $dir = dirname($file->getFilePath());
                if (! is_dir($dir)) {
                    mkdir(directory: $dir, recursive: true);
                }

                $this->writer->write(
                    $this->printer->print($this->astBuilder->build($file)),
                    $file->getFilePath(),
                );

                $output->writeln(sprintf('Created: %s', $file->getFilePath()));
            }
        }

        return Command::SUCCESS;
    }
}
