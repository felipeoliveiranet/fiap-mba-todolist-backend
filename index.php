<?php

/*
$hashs = hash_algos();

for($i=0; $i<count($hashs);$i++) {
    echo $hashs[$i] . " > " . hash($hashs[$i], time()) . "<br>";
}

exit;
*/

date_default_timezone_set('America/Sao_Paulo');

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Slim\Factory\AppFactory;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');

require __DIR__ . '/vendor/autoload.php';

const APP_CONFIGURED = true;

$app = AppFactory::create();

(require __DIR__ . '/settings.php');
(require __DIR__ . '/routes.php')($app);

$fileDate = \App\Helper\AppHelper::getFileDate();
\App\Helper\RequestHelper::setAdd($app);

header('Last-Update-Version: ' . $fileDate);

$app->addBodyParsingMiddleware();
//$app->setBasePath("/");

$app->run();

