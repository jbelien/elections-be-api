<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Entity;
use App\Reader\FormatI\Extension;
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
        $extension = new Extension(intval($year), $type, $test);

        if (!is_null($id)) {
            $result = $entity->get(intval($id))->setMunicipalities($extension->getExtensions());
        } elseif (!is_null($level)) {
            $entities = $entity->getEntities();

            $filter = array_filter($entities, function ($entity) use ($level) {
                return $entity->level === $level;
            });

            foreach ($filter as $e) {
                $result[$e->id] = $entity->get($e->id)->setMunicipalities($extension->getExtensions());
            }
        } else {
            $entities = $entity->getEntities();

            foreach ($entities as $e) {
                $result[$e->id] = $entity->get($e->id)->setMunicipalities($extension->getExtensions());
            }
        }

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
