<?php

declare(strict_types=1);

namespace ArchScaffy\Command;

use ArchScaffy\Writer\WriterInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(
    name: 'init',
    description: 'Generate configuration files and sample blueprint files'
)]
final class InitCommand extends Command
{
    private const array DEFAULT_CONFIG = [
        'global' => [
            'strict' => true,
        ],
        'class' => [
            'final' => true,
            'readonly' => true,
        ],
    ];

    private const array DEFAULT_BLUE_PRINT = [
        'layers' => [
            'LayerName' => [
                'output' => 'app/LayerName',
                'namespace' => 'App\LayerName',
            ],
        ],
        'features' => [
            'FeatureName' => [
                'components' => [
                    [
                        'name' => 'Example',
                        'layer' => 'LayerName',
                        'kind' => 'class',
                    ],
                ],
            ],
        ],
    ];

    public function __construct(private WriterInterface $writer)
    {
        parent::__construct();
    }

    public function __invoke(OutputInterface $output): int
    {
        $configFile = getcwd() . '/scaffy.config.yaml';

        if (! file_exists($configFile)) {
            $this->writer->write($this->dumpYaml(self::DEFAULT_CONFIG), $configFile);

            $output->writeln(sprintf('Created %s.', $configFile));
        } else {
            $output->writeln(sprintf('%s already exists.', $configFile));
        }

        $blueprintfFile = getcwd() . '/scaffy.blueprint.yaml';

        if (! file_exists($blueprintfFile)) {
            $this->writer->write($this->dumpYaml(self::DEFAULT_BLUE_PRINT), $blueprintfFile);

            $output->writeln(sprintf('Created %s.', $blueprintfFile));
        } else {
            $output->writeln(sprintf('%s already exists.', $blueprintfFile));
        }

        return Command::SUCCESS;
    }

    private function dumpYaml(mixed $data): string
    {
        return Yaml::dump(input: $data, inline: 6, indent: 2);
    }
}
