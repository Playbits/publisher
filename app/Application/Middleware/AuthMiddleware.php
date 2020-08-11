<?php
declare (strict_types = 1);

namespace App\Application\Middleware;

use App\Controller\AuthController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware implements Middleware {

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);
        $Authorization = explode(' ', (string) $request->getHeaderLine('Authorization'));
        $token = $Authorization[1] ?? '';
        $AuthController = new AuthController();
        $token_validate = $AuthController->validateToken($token);
        if (!$token || !$token_validate['status']) {
            $output = [
                'status' => $token_validate['status'],
                'message' => $token_validate['message'],
            ];
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode($output));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401, 'Unauthorized');
        }
        $request = $request->withAttribute('user_info', $token_validate['data']);
        return $handler->handle($request);
    }
}
