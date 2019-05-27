<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Groups;
use App\Reader\FormatI\Lists;
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

        $groups = (new Groups(intval($year), $type, $test))->getGroups();
        $lists = (new Lists(intval($year), $type, $test))->getLists();

        $groups = array_map(function ($group) use ($lists) {
            $id = $group['id'];

            $group['lists'] = array_filter($lists, function ($list) use ($id) {
                return $list['group']['id'] === $id;
            });

            return $group;
        }, $groups);

        if (!is_null($id)) {
            $result = $groups[$id];
        } else {
            $result = $groups;
        }

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
