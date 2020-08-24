<?php

namespace App\Helper;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;
use Slim\Psr7\Response;
use Throwable;


class RequestHelper
{
    public static function setAdd($app) {

        //self::authRequest();
        self::setErrorHandler($app);

        $app->add(function ($req, $res) {

            $response = $res->handle($req, $res);

            return $response
                ->withHeader('Content-type', 'application/json');
                //->withHeader('Access-Control-Allow-Origin', '"*"');
                //->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                //->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });
    }

    /** @noinspection PhpUnusedParameterInspection
     * @noinspection PhpUnused
     * @noinspection PhpUnusedPrivateMethodInspection
     */
    private static function authRequest() {

        return function (Request $request, RequestHandler $handler) {

            $token = $request->getHeader('x-todo-token');

            print_r($request->getHeaders());

            if(!isset($token)  || $token[0] != 'fiap-mba-mobile-2020') {

                $response = new Response();
                $response->getBody()->write(AppHelper::parseToJSON(['status' => 'unauthorized', 'message' => 'This API requires user authentication by token']));

                return $response->withStatus(401);
            }

            return true;
        };
    }

    /** @noinspection PhpUnusedParameterInspection */
    private static function setErrorHandler(App $app) {

        $customErrorHandler = function (
            Request $request,
            Throwable $exception,
            bool $displayErrorDetails,
            bool $logErrors,
            bool $logErrorDetails,
            $logger = null
        ) use ($app) {

            $status_code = $exception->getCode() >= 300 ? $exception->getCode() : 400;

            $payload = AppHelper::parseToJSON(["status" => "error", 'code' => $status_code, "message" => $exception->getMessage()]);

            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write($payload);

            return $response->withStatus($status_code)->withHeader("x-error-type", $exception->getMessage())->withHeader("Content-type", "application-json");
        };

        $app->addRoutingMiddleware();

        $errorMiddleware = $app->addErrorMiddleware(false, false,false);
        $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
    }
}
