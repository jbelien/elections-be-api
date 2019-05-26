<?php

declare(strict_types=1);

namespace App\Handler\FormatR;

use App\Reader\FormatR\Status;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class StatusHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');
        $level = $request->getAttribute('level');

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        $status = new Status(intval($year), $type, $level, $test, $final);

        $statuses = $status->getStatus();

        return new JsonResponse($statuses, 200, [
            'Cache-Control' => 'max-age=300, public',
        ]);
    }
}
