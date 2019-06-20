<?php

declare(strict_types = 1);

namespace App\Handler\API;

use App\Cache;
use App\Reader\FormatI\Group;
use App\Reader\FormatI\Group\X;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;

class GroupsHandler implements RequestHandlerInterface
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

        $id = $request->getAttribute('id');

        $params = $request->getQueryParams();
        $test = isset($params['test']);

        $group = new Group(intval($year), $type, $test);

        if (!is_null($id)) {
            $result = $group->get(intval($id));
        } else {
            $groups = array_filter($group->getGroups(), function (X $g) {
                return !is_null($g->id);
            });

            $result = [];
            foreach ($groups as $g) {
                $result[$g->id] = $group->get($g->id);
            }
        }

        if ($this->cache === true && isset($cache)) {
            $cache->set($result);
        }

        return new JsonResponse($result, 200, $this->headers);
    }
}
