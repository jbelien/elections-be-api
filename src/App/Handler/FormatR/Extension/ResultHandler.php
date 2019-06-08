<?php

declare(strict_types = 1);

namespace App\Handler\FormatR\Extension;

use App\Reader\FormatR\Extension\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ResultHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        if ($test === true) {
            $glob = glob(sprintf('data/%d/test/format-r/%s/R1X*.%s', $year, $final ? 'final' : 'intermediate', $type));
        } else {
            $glob = glob(sprintf('data/%d/format-r/R1X*.%s', $year, $type));
        }

        $results = [];

        foreach ($glob as $file) {
            $fname = basename($file);

            $pattern = sprintf('/R1X([0-9]+)\.%s/', $type);
            preg_match($pattern, $fname, $matches);

            $results[] = (new Result(intval($year), $type, $matches[1], $test, $final))->getArray();
        }

        return new JsonResponse($results, 200, [
            'Cache-Control' => 'max-age=300, public',
        ]);
    }
}
