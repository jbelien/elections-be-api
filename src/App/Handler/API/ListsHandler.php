<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Candidates;
use App\Reader\FormatI\Lists;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

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

        $lists = (new Lists(intval($year), $type, $test))->getLists();
        $candidates = (new Candidates(intval($year), $type, $test))->getCandidates();

        $lists = array_map(function ($list) use ($candidates) {
            $id = $list['id'];

            $list['candidates'] = array_filter($candidates, function ($candidate) use ($id) {
                return $candidate['list']['id'] === $id;
            });

            return $list;
        }, $lists);

        if (!is_null($id)) {
            $result = $lists[$id];
        } elseif (!is_null($group)) {
            $result = array_filter($lists, function ($list) use ($group) {
                return $list['group']['id'] === intval($group);
            });
        } elseif (!is_null($entity)) {
            $result = array_filter($lists, function ($list) use ($entity) {
                return $list['entity']['id'] === intval($entity);
            });
        } else {
            $result = $lists;
        }

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
