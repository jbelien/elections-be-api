<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

    $app->get('/entities/{year:[0-9]{4}}/{type:\w+}[/{id:\d+}]', App\Handler\API\EntitiesHandler::class, 'api.entities');
    $app->get('/entities/{year:[0-9]{4}}/{type:\w+}/level/{level:\w+}', App\Handler\API\EntitiesHandler::class, 'api.entities.level');

    $app->get('/groups/{year:[0-9]{4}}/{type:\w+}[/{id:\d+}]', App\Handler\API\GroupsHandler::class, 'api.groups');

    $app->get('/lists/{year:[0-9]{4}}/{type:\w+}[/{id:\d+}]', App\Handler\API\ListsHandler::class, 'api.lists');
    $app->get('/lists/{year:[0-9]{4}}/{type:\w+}/group/{group:\d+}', App\Handler\API\ListsHandler::class, 'api.lists.group');
    $app->get('/lists/{year:[0-9]{4}}/{type:\w+}/entity/{entity:\d+}', App\Handler\API\ListsHandler::class, 'api.lists.entity');

    $app->get('/candidates/{year:[0-9]{4}}/{type:\w+}[/{id:\d+}]', App\Handler\API\CandidatesHandler::class, 'api.candidates');
    $app->get('/candidates/{year:[0-9]{4}}/{type:\w+}/list/{list:\d+}', App\Handler\API\CandidatesHandler::class, 'api.candidates.list');
    $app->get('/candidates/{year:[0-9]{4}}/{type:\w+}/group/{group:\d+}', App\Handler\API\CandidatesHandler::class, 'api.candidates.group');
    $app->get('/candidates/{year:[0-9]{4}}/{type:\w+}/entity/{entity:\d+}', App\Handler\API\CandidatesHandler::class, 'api.candidates.entity');

    // $app->get('/fmedias/{year:[0-9]{4}}/{type:\w+}', App\Handler\FMediasHandler::class, 'fmedias');

    $app->get('/format-i/entity/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\EntityHandler::class, 'format-i.entity');
    $app->get('/format-i/group/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\GroupHandler::class, 'format-i.group');
    $app->get('/format-i/list/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\ListHandler::class, 'format-i.list');
    $app->get('/format-i/candidate/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\CandidateHandler::class, 'format-i.candidate');
    $app->get('/format-i/extension/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\ExtensionHandler::class, 'format-i.extension');

    $app->get('/format-r/evolution/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatR\EvolutionHandler::class, 'format-r.evolution');
    $app->get('/format-r/seats/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatR\SeatsHandler::class, 'format-r.seats');
    $app->get('/format-r/hit/{year:[0-9]{4}}/{type:\w+}/{level:\w+}', App\Handler\FormatR\HitHandler::class, 'format-r.hit');
    $app->get('/format-r/history/{year:[0-9]{4}}/{type:\w+}/{level:\w+}', App\Handler\FormatR\HistoryHandler::class, 'format-r.history');
    $app->get('/format-r/results/{year:[0-9]{4}}/{type:\w+}/{level:\w+}', App\Handler\FormatR\ResultHandler::class, 'format-r.result');

    $app->get('/format-r/eml/{year:[0-9]{4}}[/{fname:\w+}]', App\Handler\FormatR\EMLHandler::class, 'format-r.eml');

    // $app->get('/votes/candidates/{year:[0-9]{4}}/{type:\w+}/{id:[0-9]+}', App\Handler\VoteCandidatesHandler::class, 'vote.candidate');
    // $app->get('/votes/candidates/{year:[0-9]{4}}/{type:\w+}/list-{list:[0-9]+}/{type:(effective|substitues)}/{nr:[0-9]+}', App\Handler\VoteCandidateHandler::class, 'vote.candidate');
};
