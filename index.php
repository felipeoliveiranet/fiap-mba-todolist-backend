<?php

/*
$hashs = hash_algos();

for($i=0; $i<count($hashs);$i++) {
    echo $hashs[$i] . " > " . hash($hashs[$i], time()) . "<br>";
}

exit;
*/

date_default_timezone_set('America/Sao_Paulo');

header('Connection: keep-alive');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

const APP_CONFIGURED = true;

$app = AppFactory::create();

(require __DIR__ . '/settings.php');
(require __DIR__ . '/routes.php')($app);

\App\Helper\RequestHelper::setAdd($app);


$app->addBodyParsingMiddleware();
//$app->setBasePath("/");

$app->run();

