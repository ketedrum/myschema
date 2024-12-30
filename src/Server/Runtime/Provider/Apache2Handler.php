<?php

declare(strict_types=1);

namespace MySchema\Server\Runtime\Provider;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use MySchema\Server\Action\HttpRequestAction;
use MySchema\Server\Runtime\RuntimeInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Apache2Handler implements RuntimeInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
    }

    public function run(): void
    {
        // generate a PSR-7 request
        $request = ServerRequestFactory::fromGlobals();

        // handle the request
        $action = $this->eventDispatcher->dispatch(new HttpRequestAction($request));

        // emit the response
        $emitter = new SapiEmitter;
        $emitter->emit($action->getResponse());
    }
}