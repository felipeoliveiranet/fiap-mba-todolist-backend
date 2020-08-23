<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Slim\Factory\AppFactory;

require __DIR__ . '\vendor\autoload.php';

const APP_CONFIGURED = true;

$app = AppFactory::create();

(require __DIR__ . '/settings.php');
(require __DIR__ . '/routes.php')($app);

\App\Helper\RequestHelper::setAdd($app);

$app->addBodyParsingMiddleware();
$app->setBasePath("/todolist");

$app->run();
