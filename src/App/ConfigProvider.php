<?php

declare(strict_types = 1);

namespace App;

/**
 * The configuration provider for the App module.
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array.
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies.
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Handler\API\CandidatesHandler::class    => Handler\API\CandidatesHandlerFactory::class,
                Handler\FormatI\CandidateHandler::class => Handler\FormatI\CandidateHandlerFactory::class,
                Handler\FormatI\EntityHandler::class    => Handler\FormatI\EntityHandlerFactory::class,
                Handler\FormatI\ExtensionHandler::class => Handler\FormatI\ExtensionHandlerFactory::class,
                Handler\FormatI\GroupHandler::class     => Handler\FormatI\GroupHandlerFactory::class,
                Handler\FormatI\ListHandler::class      => Handler\FormatI\ListHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration.
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
