<?php

declare (strict_types = 1);

namespace App\Handler\FormatR;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Reader\FormatR\ResultD;
use Zend\Diactoros\Response\EmptyResponse;

class ResultsDHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $type = $request->getAttribute('type');
        $level = $request->getAttribute('level');

        switch ($type) {
            case 'BR': // Parlement de la Région de Bruxelles-Capitale / Brussels Hoofdstedelijk Parlement
                if (!in_array($level, ['K', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'CG': // Conseil communal / Gemeenteraden
                if (!in_array($level, ['M'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'CK': // Chambre / Kamer
                if (!in_array($level, ['K', 'C', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'CS': // Conseil CPAS / OCMWraden
                if (!in_array($level, ['M'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'DE': // Parlement de la Communauté germanophone / Parlement van de Duitstalige Gemeenschap
                if (!in_array($level, ['K', 'G'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'DI': // Conseil de district (Anvers) / Districtraden (in Antwerpen)
                if (!in_array($level, ['I'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'EU': // Parlement européen / Europese Parlement
                if (!in_array($level, ['K', 'C', 'P', 'L', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'PR': // Conseil provincial / Provincieraden
                if (!in_array($level, ['M', 'K', 'D', 'A', 'P'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'VL': // Parlement flamand / Vlaams Parlement
                if (!in_array($level, ['K', 'C', 'P', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'WL': // Parlement régional wallon / Waals Parlement
                if (!in_array($level, ['K', 'C', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
        }

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        $result = new ResultD(intval($year), $type, $level, $test, $final);

        $results = $result->getResults();

        return new JsonResponse($results, 200, [
            'Cache-Control' => 'max-age=300, public',
        ]);
    }
}
