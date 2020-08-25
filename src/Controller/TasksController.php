<?php /** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocSignatureInspection */

/** @noinspection PhpDocSignatureInspection */

namespace App\Controller;

use App\Enum\TaskStatusEnum;
use App\Helper\ResponseHelper;
use App\Repository\TasksRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TasksController
{
    /** @noinspection PhpUnusedParameterInspection
     * @noinspection PhpUnused
     */
    public function list(Request $request, Response $response, $args)
    {
        $repo = new TasksRepository();
        $result = $repo->getList();
        $result["action"] = "list";

        return ResponseHelper::processResponse($response, $result);
    }

    /** @noinspection PhpUnusedParameterInspection
     * @noinspection PhpUnused
     */
    public function get(Request $request, Response $response, $args)
    {
        $repo = new TasksRepository();
        $result = $repo->getItem($args['id_task']);
        $result["action"] = "get_item";

        return ResponseHelper::processResponse($response, $result);
    }

    /** @noinspection PhpUnusedParameterInspection
     * @noinspection PhpUnused
     */
    public function insert(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $title = isset($data['title']) && !empty($data['title']) ? $data['title'] : null;

        if($title ==null)
            throw new \Exception("Task without title!", 406);

        $repo = new TasksRepository();
        $result = $repo->insert($title);
        $result["action"] = "insert";

        return ResponseHelper::processResponse($response, $result);
    }

    /**
     * @noinspection PhpUnused
     */
    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $data = isset($args['id_task']) && !empty($args['id_task']) ? $args['id_task'] : $data['id_task'];

        $repo = new TasksRepository();
        $result = $repo->update($args['id_task'], $data);
        $result["action"] = "update";

        return ResponseHelper::processResponse($response, $result);
    }

    /** @noinspection PhpUnusedParameterInspection
     * @noinspection PhpUnused
     */
    public function updateStatus(Request $request, Response $response, $args)
    {
        $task_status = TaskStatusEnum::isValid($args['task_status'], true);

        if($task_status) {

            $repo = new TasksRepository();
            $result = $repo->updateStatus($args['id_task'], $task_status);
            $result["action"] = "update_status";

        } else {

            $result['status']   = 'error';
            $result['message']  = 'Invalid task status: ' . $args['task_status'];
            $result["action"]   = "update_status";
        }

        return ResponseHelper::processResponse($response, $result);
    }

    /** @noinspection PhpUnusedParameterInspection
     * @noinspection PhpUnused
     */
    public function delete(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $data = isset($args['id_task']) && !empty($args['id_task']) ? $args['id_task'] : $data['id_task'];

        $repo = new TasksRepository();
        $result = $repo->delete($data);
        $result["action"] = "delete";

        return ResponseHelper::processResponse($response, $result);
    }
}
