<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Entities;
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

        $entities = (new Entities(intval($year), $type, $test))->getEntities();

        if (!is_null($id)) {
            $result = $entities[$id];
        } elseif (!is_null($level)) {
            $result = array_filter($entities, function ($entity) use ($level) {
                return $entity['level'] === $level;
            });
        } else {
            $result = $entities;
        }

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
