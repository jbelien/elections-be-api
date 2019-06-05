<?php

declare(strict_types=1);

namespace App\Handler\FormatR;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\XmlResponse;

class EMLHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $year = $request->getAttribute('year');
        $fname = $request->getAttribute('fname');

        $params = $request->getQueryParams();
        $test = isset($params['test']);
        $final = $test && isset($params['final']);

        if ($test === true) {
            $directory = sprintf('data/%d/test/format-r/%s/eml', $year, $final ? 'final' : 'intermediate');
        } else {
            $directory = sprintf('data/%d/format-r/eml', $year);
        }

        if (!is_null($fname)) {
            if (file_exists($directory.'/'.$fname.'.EML')) {
                return new XmlResponse(file_get_contents($directory.'/'.$fname.'.EML'), 200, [
                    'Cache-Control' => 'max-age=300, public',
                ]);
            } else {
                return new EmptyResponse(404);
            }
        }

        $glob = glob($directory.'/*.EML');
        $files = array_map(function ($path) {
            return basename($path);
        }, $glob);

        return new JsonResponse($files, 200, [
            'Cache-Control' => 'max-age=300, public',
        ]);
    }
}
