<?php

declare(strict_types=1);

namespace App\Handler;

use App\Reader\Municipality;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class MunicipalityHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $year = $request->getAttribute('year');
        $nis = $request->getAttribute('nis');

        $municipality = (new Municipality(intval($year)))->getMunicipalities();

        if (!is_null($nis)) {
            return new JsonResponse($municipality[$nis]);
        } else {
            return new JsonResponse($municipality);
        }
    }
}
