<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var RouterInterface */
    private $router;

    public function __construct(string $containerName, RouterInterface $router)
    {
        $this->containerName = $containerName;
        $this->router = $router;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new RedirectResponse('https://github.com/jbelien/elections-be-api', 307);
    }
}
