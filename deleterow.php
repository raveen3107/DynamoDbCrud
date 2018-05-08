<?php
require 'vendor/aws/aws-autoloader.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

$sdk = new Aws\Sdk([
    //'endpoint'   => 'http://localhost:8000',
    'region'   => 'us-east-2',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'Movies';

$year = 2019;
$title = 'hhello';

$key = $marshaler->marshalJson('
    {
        "year": ' . $year . ', 
        "title": "' . $title . '"
    }
');



$params = [
    'TableName' => $tableName,
    'Key' => $key 
    
];

try {
    $result = $dynamodb->deleteItem($params);
    echo "Deleted item.\n";

} catch (DynamoDbException $e) {
    echo "Unable to delete item:\n";
    echo $e->getMessage() . "\n";
}

?>

