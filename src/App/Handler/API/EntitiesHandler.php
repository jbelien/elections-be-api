<?php

declare (strict_types = 1);

namespace App\Handler\API;

use App\Cache;
use App\Model\Entity as ModelEntity;
use App\Reader\FormatI\Entity;
use App\Reader\FormatI\Entity\E;
use App\Reader\FormatI\Extension;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;

class EntitiesHandler implements RequestHandlerInterface
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

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $geoJSON = isset($params['geojson']);

        if ($this->cache === true) {
            $path = Cache::path($routeResult->getMatchedRouteName(), $routeResult->getMatchedParams(), $geoJSON === true ? 'geojson' : 'json');
            $cache = new Cache($path);

            $json = $cache->get();

            if (!is_null($json)) {
                return new JsonResponse($json, 200, $this->headers);
            }
        }

        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $id = $request->getAttribute('id');
        $level = $request->getAttribute('level');

        $entity = new Entity(intval($year), $type, $test);
        $extension = new Extension(intval($year), $type, $test);

        if (!is_null($id)) {
            $result = $entity->get(intval($id))->setMunicipalities($extension->getExtensions());
        } elseif (!is_null($level)) {
            $entities = $entity->getEntities();

            $filter = array_filter($entities, function (E $entity) use ($level) {
                return $entity->level === $level;
            });

            $result = [];
            foreach ($filter as $e) {
                $result[$e->id] = $entity->get($e->id)->setMunicipalities($extension->getExtensions());
            }
        } else {
            $entities = $entity->getEntities();

            $result = [];
            foreach ($entities as $e) {
                $result[$e->id] = $entity->get($e->id)->setMunicipalities($extension->getExtensions());
            }
        }

        if ($geoJSON === true) {
            $result = self::toGeoJSON($result, intval($year));
        }

        if ($this->cache === true && isset($cache)) {
            $cache->set($result);
        }

        return new JsonResponse($result, 200, $this->headers);
    }

    private static function toGeoJSON($result, int $year)
    {
        if ($result instanceof ModelEntity) {
            return $result->toGeoJSON($year);
        }

        $geoJSON = [
            'type'     => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($result as $r) {
            $geoJSON['features'][] = $r->toGeoJSON($year);
        }

        return $geoJSON;
    }
}
