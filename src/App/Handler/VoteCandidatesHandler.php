<?php

declare(strict_types=1);

namespace App\Handler;

use App\Reader\FormatI\Candidate;
use App\Reader\FormatR\ResultD;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

class VoteCandidatesHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');
        $id = $request->getAttribute('id');

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        $candidates = (new Candidate(intval($year), $type, $test))->getCandidates();

        if (!isset($candidates[$id])) {
            return new EmptyResponse(404);
        }

        $candidate = $candidates[$id];

        $list = $candidate['list'];
        $entity = $list['entity'];

        $results = (new ResultD(intval($year), $type, $candidate['level'], $test, $final))->getResults();

        $candidate['votes'] = $results[$entity['id']]['results'][$list['id']]['candidates'][$candidate['id']]['votes'];

        return new JsonResponse($candidate);
    }
}
