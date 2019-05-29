<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Entity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class EntitiesHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $id = $request->getAttribute('id');
        $level = $request->getAttribute('level');

        $params = $request->getQueryParams();
        $test = isset($params['test']);

        $entity = new Entity(intval($year), $type, $test);

        if (!is_null($id)) {
            $result = $entity->get(intval($id));
        } elseif (!is_null($level)) {
            $entities = $entity->getEntities();

            $filter = array_filter($entities, function ($entity) use ($level) {
                return $entity->level === $level;
            });

            foreach ($filter as $e) {
                $result[$e->id] = $entity->get($e->id);
            }
        } else {
            $entities = $entity->getEntities();

            foreach ($entities as $e) {
                $result[$e->id] = $entity->get($e->id);
            }
        }

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
