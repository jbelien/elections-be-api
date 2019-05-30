<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Group;
use App\Reader\FormatI\Group\X;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class GroupsHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
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

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
