<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Liste;
use App\Reader\FormatI\Liste\L;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Model\Liste as ModelListe;

class ListsHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
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

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
