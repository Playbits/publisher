<?php
declare (strict_types = 1);

use DI\Container;
use DI\ContainerBuilder;
use Monolog\Logger;
use Awurth\SlimValidation\Validator;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $container = new Container();
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // set to false in production
            "determineRouteBeforeAppMiddleware" => true, // CORS
            'debug' => true,
            'logger' => [
                'name' => 'slim-app',
                'path' => __DIR__ . '/../var/logs/app.log',
                'level' => Logger::DEBUG,
            ],
        ],
    ]);
    // $container->set('validator', function () {
    //     return new Validator();
    // });
};
