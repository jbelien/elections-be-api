<?php

declare (strict_types = 1);

namespace App\Handler\FormatI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Reader\FormatI\Group;
use Zend\Diactoros\Response\JsonResponse;

class GroupsHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $params = $request->getQueryParams();
        $test = isset($params['test']);

        $group = new Group(intval($year), $type, $test);

        $groups = $group->getGroups();

        return new JsonResponse($groups);
    }
}
