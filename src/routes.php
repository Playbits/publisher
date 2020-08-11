<?php
declare (strict_types = 1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Exception\HttpNotFoundException;

return function (App $app) {
// Routes
    $app->post('/subscribe/{topic}', 'App\Controller\PublisherController:subscribe')->setName('subscribe');
    $app->post('/publish/{topic}', 'App\Controller\PublisherController:publishTopic')->setName('publish');
    $app->post('/event', 'App\Controller\PublisherController:publishEvent')->setName('publishEvent');
    
    // This line bellow allows CORS Response to preflight
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        // $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    });
    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: make sure this route is defined last
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
