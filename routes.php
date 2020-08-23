<?php

/** @noinspection PhpUnused */

use App\Controller\TasksController;

use Slim\App;

return function(App $app) {

    $app->group('/tasks', function ($app) {

        $app->get('/', [TasksController::class, 'list']);
        $app->post('/', [TasksController::class, 'insert']);

        $app->group('/{id_task:[0-9]+}', function ($app) {

            $app->get('', [TasksController::class, 'get']);
            $app->patch('', [TasksController::class, 'update']);
            $app->patch('/{task_status}', [TasksController::class, 'updateStatus']);
            $app->delete('', [TasksController::class, 'delete']);
        });
    });
};