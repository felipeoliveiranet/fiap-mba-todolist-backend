<?php /** @noinspection PhpUnused */

namespace App\Repository;

use App\Enum\AwsExceptionEnum;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\Sdk;

class DynamoDBRepository {

	protected Sdk $sdk;
    protected DynamoDbClient $db;
    protected array $tables = array();

	function __construct() {
		
		$this->sdk = new Sdk([
			'region'  => 'local',
			'version'  => 'latest',
			'endpoint' => 'http://localhost:8000',
			 'credentials' => [
				 'key' => 'fakeMyKeyIdkey',
				 'secret' => 'fakeSecretAccessKey',
			 ],
		]);
		
		$this->db = $this->sdk->createDynamoDb();

        if(!APP_CONFIGURED) {

            $this->dropTables();
            $this->createTable($this->tableTasks());
        }
	}

	function tableTasks() {
		
		return [
			'TableName' => 'Tasks',
			'KeySchema' => [
				[
					'AttributeName' => 'id_task',
					'KeyType' => 'HASH'
				],
			],
			'AttributeDefinitions' => [
				[
					'AttributeName' => 'id_task',
					'AttributeType' => 'N'
				],
			],
			'ProvisionedThroughput' => [
				'ReadCapacityUnits' => 10,
				'WriteCapacityUnits' => 10
			]
		];
	}

	function createTable($table) {
			
		try {

		    $this->db->describeTable(["TableName" => $table['TableName']]);

    	} catch (DynamoDbException $e) {

		    if(AwsExceptionEnum::TABLE_NOT_EXIST == $e->getAwsErrorCode()) {

                try {

                    $result = $this->db->createTable($table);
                    echo 'Created table.  Status: ' . $result['TableDescription']['TableStatus'] . "\n";

                } catch (DynamoDbException $e) {

                    throw new \Exception('Internal server error: #0xDB01C', 500);
                }
            }
		} catch (\Exception $e) {}
	}
	
	function dropTable($table) {

		try {

            $this->db->deleteTable(['TableName' => 'Tasks']);

    	} catch (DynamoDbException $e) {

		    if(AwsExceptionEnum::TABLE_NOT_EXIST == $e->getAwsErrorCode())
		        throw new \Exception('Internal server error: #0xDB01D01T', 500);

		} catch (\Exception $e) {}
	}

	function dropTables() {

		self::dropTable(['TableName' => 'Tasks']);
	}
}
 
