<?php
namespace App\Controller;
use Awurth\SlimValidation\Validator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory as App;

class Controller {

    protected $logger;
    protected $render;
    protected $container;
    protected $validator;
    protected $app;
    protected $secret;

    function __construct() {
        $app = App::create();
        $container = $app->getContainer();
        $logger = $container->get(LoggerInterface::class);
        $this->app = $app;
        $this->container = $container;
        $this->logger = $logger;
    }

    public function index($request, $response, $args) {
        return $response->withRedirect('/documentation/', 301);
    }

    /* This method format response output to json */
    protected function responseWithJson(Response $response, Array $output, $status = 200): Response {
        $payload = json_encode($output, true);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
    /* this method returns instance of Validator */
    protected function requestValidator(): Validator {
        return new Validator();
    }
    /* this method checks request Validator */
    protected function checkValidation(Validator $validator) {
        if (!$validator->isValid()) {
            $errors = $validator->getErrors();
            $output['status'] = false;
            $output['code'] = 400;
            $output['message'] = $errors;
            return $output;
        }
        return true;
    }
    /* Json file manipulation methods */
    protected function saveJson($data, $file, $append = false) {
        $output = json_encode($data, JSON_PRETTY_PRINT);
        $write = ($append) ? file_put_contents($file, $output, FILE_APPEND | LOCK_EX) : file_put_contents($file, $output, LOCK_EX);
        return $write;
    }
    protected function readJson($file) {
        $data = file_get_contents($file);
        return json_decode($data, true);
    }
    protected function jsonToArray($data) {
        return json_decode($data, true);
    }

}
