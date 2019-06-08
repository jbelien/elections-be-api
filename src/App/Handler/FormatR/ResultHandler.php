<?php

declare(strict_types=1);

namespace App\Handler\FormatR;

use App\Reader\FormatR\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

class ResultHandler implements RequestHandlerInterface
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
                if (!in_array($level, ['K', 'P', 'C', 'L', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'PR': // Conseil provincial / Provincieraden
                if (!in_array($level, ['M', 'K', 'D', 'A', 'P'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'VL': // Parlement flamand / Vlaams Parlement
                if (!in_array($level, ['K', 'C', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
            case 'WL': // Parlement régional wallon / Waals Parlement
                if (!in_array($level, ['K', 'C', 'P', 'R'])) {
                    return new EmptyResponse(404);
                }
                break;
        }

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        if ($test === true) {
            $glob = glob(sprintf('data/%d/test/format-r/%s/R{0,1}%s*.%s', $year, $final ? 'final' : 'intermediate', $level, $type), GLOB_BRACE);
        } else {
            $glob = glob(sprintf('data/%d/format-r/R{0,1}%s*.%s', $year, $level, $type), GLOB_BRACE);
        }

        $files = [];
        $count0 = [];

        foreach ($glob as $file) {
            $fname = basename($file);

            $pattern = sprintf('/R([0-1])%s([0-9]+)(?:_([0-9]+))?\.%s/', $level, $type);
            preg_match($pattern, $fname, $matches);

            if (intval($matches[1]) === 0 && in_array($level, ['K', 'M', 'I'])) {
                $count = intval($matches[3]);

                if (!isset($count0[$matches[2]]) || $count > $count0[$matches[2]]) {
                    $count0[$matches[2]] = $count;
                }
            } else {
                $files[] = $fname;
            }
        }

        foreach ($count0 as $nis => $count) {
            $fname1 = sprintf('R1%s%s.%s', $level, $nis, $type);
            $fname0 = sprintf('R0%s%s_%s.%s', $level, $nis, str_pad((string) $count, 3, '0', STR_PAD_LEFT), $type);

            if (!in_array($fname1, $files)) {
                $files[] = $fname0;
            }
        }

        $results = [];

        foreach ($files as $fname) {
            $pattern = sprintf('/R([0-1])%s([0-9]+)(?:_([0-9]+))?\.%s/', $level, $type);
            preg_match($pattern, $fname, $matches);

            $results[] = (new Result(
                intval($year),
                $type,
                intval($matches[1]),
                $level,
                $matches[2],
                $test,
                $final,
                $matches[3] ?? null
            ))->getArray();
        }

        return new JsonResponse(count($results) === 1 ? current($results) : $results, 200, [
            'Cache-Control' => 'max-age=300, public',
        ]);
    }
}
