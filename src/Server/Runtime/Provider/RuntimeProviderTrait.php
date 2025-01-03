<?php

declare(strict_types=1);

namespace MySchema\Server\Runtime\Provider;

use Mezzio\Router\RouteCollectorInterface;
use MySchema\Action\ActionMiddleware;
use MySchema\Server\Middleware\LazyLoadingMiddleware;
use Psr\Container\ContainerInterface;

trait RuntimeProviderTrait
{
    private function setupRouting(ContainerInterface $container): void
    {
        $routes = $container->get('config')['routes'] ?? [];

        // prep default route options
        $defaultRouteOptions = [];

        $routeCollector = $container->get(RouteCollectorInterface::class);
        foreach ($routes as $pattern => $routeConfig) {
            // prep middleware
            $middleware = $routeConfig['middleware'] ?? [];
            $middleware[] = ActionMiddleware::class;

            // collect route
            $route = $routeCollector->route(
                path: $pattern,
                middleware: new LazyLoadingMiddleware($container, $middleware),
                methods: $routeConfig['methods'] ?? ['GET'],
                name: $routeConfig['name'],
            );

            // set options
            $route->setOptions(\array_merge($defaultRouteOptions, $routeConfig['options'] ?? []));
        }
    }
}
