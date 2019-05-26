<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;

    public function __construct(
        string $containerName,
        Router\RouterInterface $router,
        TemplateRendererInterface $template
    ) {
        $this->containerName = $containerName;
        $this->router = $router;
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new RedirectResponse('https://github.com/jbelien/elections-be-api', 307);
        // return new HtmlResponse($this->template->render('app::home-page', []));
    }
}
