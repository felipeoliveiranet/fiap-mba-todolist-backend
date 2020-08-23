<?php

namespace App\Repository;

use App\Enum\AwsExceptionEnum;
use App\Enum\TaskStatusEnum;
use App\Helper\AppHelper;
use Aws\DynamoDb\Exception\DynamoDbException;
use Exception;

class TasksRepository extends DynamoDBRepository {

    function getList()
    {
        try {

            $items = current((array)$this->db->scan(array('TableName' => 'Tasks')));

            $result['data'] = isset($items["Items"]) ? $items["Items"] : [];
            $result['status']  = !empty($result['data']) ? 'success' : 'fail';

            return $result;

        } catch (Exception $e) {

           throw new $e;
        }
    }

    function getItem(Int $id_task)
    {
        $params = [
            'TableName' => "Tasks",
            'Key' => [
                'id_task' => ['N' => $id_task]
            ]
        ];

        $item = $this->db->getItem($params);

        $result['data'] = isset($item["Item"]) ? $item["Item"] : [];
        $result['status']  = 'success';

        if(empty($item["Item"]))
            throw new \Exception('Task with ID \'' . $id_task . '\' not found', 412);

        return $result;
}

    function insert(String $title) {

        try {

            $date		= AppHelper::getDatetime();
			$id			= time();

			$param = array(
                'TableName' => 'Tasks',
                'Item' => array(
                    'id_task'   	=> array('N' => $id),
                    'created'  	    => array('S' => $date),
                    'updated'  	    => array('S' => $date),
                    'title'   	    => array('S' => $title),
                    'task_status'   => array('S' => TaskStatusEnum::TODO)
                ),
                'ReturnValues' => 'ALL_OLD',
            );

			$this->db->putItem($param);

            $result = $this->getItem($id);
            $result['status'] = 'success';

			return $result;

        } catch (Exception $e) {

            throw new $e;
        }
	}

    function update($id_task, $title) {

        try {

			$date = AppHelper::getDatetime();

            $param = [
                'TableName' => 'Tasks',
                'Key' => [
                    'id_task' => ['N' => $id_task]
                ],
                "UpdateExpression" => "SET title = :title, updated = :updated",
                "ConditionExpression" => "id_task = :id_task",
                "ExpressionAttributeValues" => [
                    ":id_task" =>  ["N" => $id_task],
                    ":title" =>  ["S" => $title],
                    ":updated" =>  ["S" => $date]
                ],
            ];

            $this->db->updateItem($param);

            $result = $this->getItem($id_task);
            $result['status'] = 'success';

            return $result;

        } catch (DynamoDbException $e) {

            if(AwsExceptionEnum::CONDITIONAL_FAIL == $e->getAwsErrorCode())
                throw new \Exception('Task with ID \'' . $id_task . '\' not found', 412);
            else
                throw $e;
        }
	}

    function updateStatus($id_task, $task_status) {

        try {

            $date = AppHelper::getDatetime();

            $param = [
                'TableName' => 'Tasks',
                'Key' => [
                    'id_task' => ['N' => $id_task]
                ],
                "UpdateExpression" => "SET task_status = :task_status, updated = :updated",
                "ConditionExpression" => "id_task = :id_task",
                "ExpressionAttributeValues" => [
                    ":id_task" =>  ["N" => $id_task],
                    ":task_status" =>  ["S" => $task_status],
                    ":updated" =>  ["S" => $date]
                ],
                'ReturnValues' => 'UPDATED_NEW',
            ];

            $this->db->updateItem($param);

            $result = $this->getItem($id_task);
            $result['status'] = 'success';

            return $result;

        } catch (DynamoDbException $e) {

            if(AwsExceptionEnum::CONDITIONAL_FAIL == $e->getAwsErrorCode())
                throw new \Exception('Task with ID \'' . $id_task . '\' not found', 412);
            else
                throw $e;
        }
    }

    function delete($id_task) {

        try {

            $param = [
                'TableName' => 'Tasks',
                'Key' => [
                    'id_task' => ['N' => $id_task]
                ],
                "ConditionExpression" => "id_task = :id_task",
                "ExpressionAttributeValues" => [
                    ":id_task" =>  ["N" => $id_task],
                ],
                'ReturnValue', 'ALL_OLD'
            ];

            $result = $this->db->deleteItem($param);

            return isset($result['ConsumedCapacity']) ? ['status' => 'fail', 'message' => 'Task does not exist'] : ['status' => 'success'];

        } catch (DynamoDbException $e) {

            if(AwsExceptionEnum::CONDITIONAL_FAIL == $e->getAwsErrorCode())
                throw new \Exception('Task with ID \'' . $id_task . '\' not found', 412);
            else
                throw $e;
        }
    }
}

