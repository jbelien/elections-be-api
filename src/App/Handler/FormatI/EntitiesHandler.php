<?php

declare(strict_types=1);

namespace App\Handler\FormatI;

use App\Reader\FormatI\Entity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class EntitiesHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $params = $request->getQueryParams();
        $test = isset($params['test']);

        $entity = new Entity(intval($year), $type, $test);

        $entities = $entity->getEntities();

        return new JsonResponse($entities, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
