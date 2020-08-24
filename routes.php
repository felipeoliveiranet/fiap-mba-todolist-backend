<?php

/** @noinspection PhpUnused */

use App\Controller\TasksController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function(App $app) {

    $app->get('/', function(Request $request, Response $response, $args) {

        $request->getBody()->write("Welcome to the great Todolist of AWS Elastic Beanstalk and DynamoDB \o/");
    });

    $app->group('/tasks', function ($app) {

        $app->get('/', [TasksController::class, 'list']);
        $app->post('/', [TasksController::class, 'insert']);

        $app->group('/{id_task}', function ($app) {

            $app->get('', [TasksController::class, 'get']);
            $app->patch('', [TasksController::class, 'update']);
            $app->patch('/{task_status}', [TasksController::class, 'updateStatus']);
            $app->delete('', [TasksController::class, 'delete']);
        });
    });
};