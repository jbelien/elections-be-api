<?php

declare(strict_types = 1);

namespace App\Handler\API;

use App\Cache;
use App\Model\Candidate as ModelCandidate;
use App\Reader\FormatI\Candidate;
use App\Reader\FormatI\Candidate\C;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;

class CandidatesHandler implements RequestHandlerInterface
{
    private $cache;
    private $headers = [
        'Cache-Control' => 'max-age=86400, public',
    ];

    public function __construct(bool $cache)
    {
        $this->cache = $cache;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routeResult = $request->getAttribute(RouteResult::class);

        if ($this->cache === true) {
            $path = Cache::path($routeResult->getMatchedRouteName(), $routeResult->getMatchedParams());
            $cache = new Cache($path);

            $json = $cache->get();

            if (!is_null($json)) {
                return new JsonResponse($json, 200, $this->headers);
            }
        }

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

        if ($this->cache === true && isset($cache)) {
            $cache->set($result);
        }

        return new JsonResponse($result, 200, $this->headers);
    }
}
