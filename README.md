# Arch Scaffy

Arch Scaffy is a CLI tool that generates boilerplate code for PHP projects using recommended architectural structures.  
You can quickly set up Layered Architecture, Clean Architecture, Domain-Driven Design (DDD), and more, with best practices out of the box.

## Requirements

|name|version|
|---|---|
|PHP|^8.4|

## Installation

```bash
composer require --dev sayuprc/arch-scaffy
```

## Usage

### Initialize

```bash
./vendor/bin/scaffy init
```

After running the init command, the directories `scaffy.config.yaml` and `scaffy.blueprint.yaml` will be generated.

### Generate codes

```bash
./vendor/bin/scaffy generate
```

## Configuration

If you are using VSCode, you can enable YAML autocompletion by adding the following settings to your `.vscode/settings.json` file:

```json
{
  "yaml.schemas": {
    "./vendor/sayuprc/arch-scaffy/resources/schema/config.schema.json": "scaffy.config.yaml",
    "./vendor/sayuprc/arch-scaffy/resources/schema/blueprint.schema.json": "scaffy.blueprint.yaml",
  }
}
```

With this configuration, VSCode provides schema-based autocompletion and validation for YAML files.
