<?php

declare(strict_types=1);

namespace MySchema\App;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'resources' => $this->getResources(),
            'routes' => $this->getRoutes(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'factories' => [
                AppManager::class => AppManagerFactory::class,
            ],
        ];
    }

    private function getResources(): array
    {
        return [
            'blocks' => [
                'main::dashboard-apps' => [
                    'file' => '/resources/blocks/dashboard/apps.html',
                    'innerHTML' => false,
                    'repeating' => true,
                ],
            ],
            'templates' => [],
        ];
    }

    private function getRoutes(): array
    {
        return [
            '/' => [
                'methods' => ['GET', 'POST'],
                'name' => 'main::content-dashboard',
                'options' => [
                    'template' => 'main::content-dashboard',
                ],
            ],
        ];
    }
}
