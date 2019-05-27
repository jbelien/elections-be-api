<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/*
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

    $app->get('/fmedias/{year:[0-9]{4}}/{type:\w+}', App\Handler\FMediasHandler::class, 'fmedias');

    $app->get('/format-i/entities/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\EntitiesHandler::class, 'format-i.entities');
    $app->get('/format-i/groups/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\GroupsHandler::class, 'format-i.groups');
    $app->get('/format-i/lists/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\ListsHandler::class, 'format-i.lists');
    $app->get('/format-i/candidates/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatI\CandidatesHandler::class, 'format-i.candidates');

    $app->get('/format-r/evolution/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatR\EvolutionHandler::class, 'format-r.evolution');
    $app->get('/format-r/results/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatR\ResultsHandler::class, 'format-r.results');
    $app->get('/format-r/results/{year:[0-9]{4}}/{type:\w+}/{level:\w+}', App\Handler\FormatR\ResultsDHandler::class, 'format-r.resultsd');
    $app->get('/format-r/status/{year:[0-9]{4}}/{type:\w+}/{level:\w+}', App\Handler\FormatR\StatusHandler::class, 'format-r.status');
    $app->get('/format-r/seats/{year:[0-9]{4}}/{type:\w+}', App\Handler\FormatR\SeatsHandler::class, 'format-r.seats');

    $app->get('/municipalities/{year:[0-9]{4}}[/{nis:[0-9]{5}}]', App\Handler\MunicipalityHandler::class, 'municipality');

    $app->get('/votes/candidates/{year:[0-9]{4}}/{type:\w+}/{id:[0-9]+}', App\Handler\VoteCandidatesHandler::class, 'vote.candidate');
    // $app->get('/votes/candidates/{year:[0-9]{4}}/{type:\w+}/list-{list:[0-9]+}/{type:(effective|substitues)}/{nr:[0-9]+}', App\Handler\VoteCandidateHandler::class, 'vote.candidate');
};
