<?php

declare(strict_types = 1);

namespace App\Handler\FormatI;

use App\Cache;
use App\Reader\FormatI\Entity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;

class EntityHandler implements RequestHandlerInterface
{
    private $cache;
    private $headers = [
        'Cache-Control' => 'max-age=86400, public',
    ];

    public function __construct(bool $cache)
    {
        $this->cache = $cache;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);

        if ($this->cache === true) {
            $path = Cache::path($routeResult->getMatchedRouteName(), $routeResult->getMatchedParams());
            $cache = new Cache($path);

            $json = $cache->get();

            if (!is_null($json)) {
                return new JsonResponse($json, 200, $this->headers);
            }
        }

        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $params = $request->getQueryParams();
        $test = isset($params['test']);

        $entity = new Entity(intval($year), $type, $test);

        if ($this->cache === true && isset($cache)) {
            $cache->set($entity->getArray());
        }

        return new JsonResponse($entity->getArray(), 200, $this->headers);
    }
}
