<?php

declare(strict_types=1);

namespace MySchema\Database;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'console' => $this->getConsoleCommands(),
            'dependencies' => $this->getDependencies(),
            'schema' => $this->getSchemaConfig(),
        ];
    }

    private function getConsoleCommands(): array
    {
        return [
            'commands' => [
                Migrator\RollBackCommand::class,
                Migrator\RunCommand::class,
                Migrator\StatusCommand::class,
            ],
        ];
    }

    private function getDependencies(): array
    {
        return [
            'factories' => [
                Migrator\RollBackCommand::class => \MySchema\Helper\ConsoleCommandFactory::class,
                Migrator\RunCommand::class => \MySchema\Helper\ConsoleCommandFactory::class,
                Migrator\StatusCommand::class => \MySchema\Helper\ConsoleCommandFactory::class,
            ],
        ];
    }

    private function getSchemaConfig(): array
    {
        return [
            'main' => [
                'migration' => [
                    'columns' => [
                        'id' => [
                            'type' => 'bigint',
                            'unsigned' => TRUE,
                            'autoIncrement' => TRUE,
                        ],
                        'name' => [
                            'type' => 'string',
                        ],
                        'definitions' => [
                            'type' => 'json',
                        ],
                        'status' => [
                            'type' => 'smallint',
                            'default' => 0,
                        ],
                        'created_at' => [
                            'type' => 'datetimetz',
                        ],
                        'executed_at' => [
                            'type' => 'datetimetz',
                            'notnull' => FALSE,
                        ],
                    ],
                    'indexes' => [
                        'migration_status' => [
                            'column' => ['status'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
