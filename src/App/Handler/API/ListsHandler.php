<?php

declare(strict_types = 1);

namespace App\Handler\API;

use App\Cache;
use App\Model\Liste as ModelListe;
use App\Reader\FormatI\Liste;
use App\Reader\FormatI\Liste\L;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;

class ListsHandler implements RequestHandlerInterface
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
        $group = $request->getAttribute('group');
        $entity = $request->getAttribute('entity');

        $params = $request->getQueryParams();
        $test = isset($params['test']);

        $list = new Liste(intval($year), $type, $test);

        if (!is_null($id)) {
            $result = $list->get(intval($id));
        } else {
            $lists = array_filter($list->getLists(), function (L $l) {
                return !is_null($l->id);
            });

            $result = [];
            foreach ($lists as $l) {
                $result[$l->id] = $list->get($l->id);
            }

            if (!is_null($group)) {
                $result = array_filter($result, function (ModelListe $list) use ($group) {
                    return $list->idGroup === intval($group);
                });
            } elseif (!is_null($entity)) {
                $result = array_filter($result, function (ModelListe $list) use ($entity) {
                    return $list->idEntity === intval($entity);
                });
            }
        }

        if ($this->cache === true && isset($cache)) {
            $cache->set($result);
        }

        return new JsonResponse($result, 200, $this->headers);
    }
}
