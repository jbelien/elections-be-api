<?php

declare(strict_types=1);

namespace App\Handler\FormatR;

use App\Reader\FormatR\Seats;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

class SeatsHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        $seats = (new Seats(intval($year), $type, $test, $final))->getSeats();

        return new JsonResponse($seats, 200, [
            'Cache-Control' => 'max-age=300, public',
        ]);
    }
}
