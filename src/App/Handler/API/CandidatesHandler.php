<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Reader\FormatI\Candidates;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class CandidatesHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $id = $request->getAttribute('id');
        $list = $request->getAttribute('list');
        $group = $request->getAttribute('group');
        $entity = $request->getAttribute('entity');

        $params = $request->getQueryParams();
        $test = isset($params['test']);

        $candidates = (new Candidates(intval($year), $type, $test))->getCandidates();

        if (!is_null($id)) {
            $result = $candidates[$id];
        } elseif (!is_null($list)) {
            $result = array_filter($candidates, function ($candidate) use ($list) {
                return $candidate['list']['id'] === intval($list);
            });
        } elseif (!is_null($group)) {
            $result = array_filter($candidates, function ($candidate) use ($group) {
                return $candidate['list']['group']['id'] === intval($group);
            });
        } elseif (!is_null($entity)) {
            $result = array_filter($candidates, function ($candidate) use ($entity) {
                return $candidate['list']['entity']['id'] === intval($entity);
            });
        } else {
            $result = $candidates;
        }

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
