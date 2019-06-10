<?php

declare (strict_types = 1);

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

        $files = [];

        if ($test === true) {
            $glob = glob(sprintf('data/%d/test/format-r/%s/R1%s*.%s', $year, $final ? 'final' : 'intermediate', $level, $type), GLOB_BRACE);
        } else {
            $glob = glob(sprintf('data/%d/format-r/R1%s*.%s', $year, $level, $type), GLOB_BRACE);
        }

        $status1 = [];

        foreach ($glob as $file) {
            $fname = basename($file);

            $pattern = sprintf('/R1%s([0-9]+)?\.%s/', $level, $type);
            preg_match($pattern, $fname, $matches);

            $files[] = $fname;
            $status1[] = $matches[1];
        }

        if ($test === true) {
            $glob = glob(sprintf('data/%d/test/format-r/%s/R0%s*.%s', $year, $final ? 'final' : 'intermediate', $level, $type), GLOB_BRACE);
        } else {
            $glob = glob(sprintf('data/%d/format-r/R0%s*.%s', $year, $level, $type), GLOB_BRACE);
        }

        $status0 = [];

        foreach ($glob as $file) {
            $fname = basename($file);

            $pattern = sprintf('/R0%s([0-9]+)(?:_([0-9]+))?\.%s/', $level, $type);
            preg_match($pattern, $fname, $matches);

            if (in_array($matches[1], $status1)) {
                continue;
            }

            if (in_array($level, ['K', 'M', 'I'])) {
                $count = intval($matches[2]);

                if (!isset($status0[$matches[1]]) || $count > $status0[$matches[1]]) {
                    $status0[$matches[1]] = $count;
                }
            } else {
                $files[] = $fname;
            }
        }

        foreach ($status0 as $nis => $count) {
            $files[] = sprintf('R0%s%s_%s.%s', $level, $nis, str_pad((string)$count, 3, '0', STR_PAD_LEFT), $type);
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
