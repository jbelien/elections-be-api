<?php

declare(strict_types=1);

namespace App\Handler\API;

use App\Model\Candidate as ModelCandidate;
use App\Reader\FormatI\Candidate;
use App\Reader\FormatI\Candidate\C;
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

        $candidate = new Candidate(intval($year), $type, $test);

        if (!is_null($id)) {
            $result = $candidate->get(intval($id));
        } else {
            $candidates = array_filter($candidate->getCandidates(), function (C $c) {
                return !is_null($c->id);
            });

            $result = [];
            foreach ($candidates as $c) {
                $result[$c->id] = $candidate->get($c->id);
            }

            if (!is_null($list)) {
                $result = array_filter($result, function (ModelCandidate $candidate) use ($list) {
                    return $candidate->idList === intval($list);
                });
            } elseif (!is_null($group)) {
                $result = array_filter($result, function (ModelCandidate $candidate) use ($group) {
                    return $candidate->idGroup === intval($group);
                });
            } elseif (!is_null($entity)) {
                $result = array_filter($result, function (ModelCandidate $candidate) use ($entity) {
                    return $candidate->idEntity === intval($entity);
                });
            }
        }

        return new JsonResponse($result, 200, [
            'Cache-Control' => 'max-age=86400, public',
        ]);
    }
}
