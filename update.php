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

 
$eav = $marshaler->marshalJson('
    {
        ":r": 3.0 ,
        ":p": "Everything happensss."
       
    }
');

$params = [
    'TableName' => $tableName,
    'Key' => $key,
    'UpdateExpression' => 
        'set info.rating = :r, info.plot=:p',
    'ExpressionAttributeValues'=> $eav,
   'ReturnValues' => 'UPDATED_NEW'
];

try {
    $result = $dynamodb->updateItem($params);
    echo "Updated item.\n";
    print_r($result['Attributes']);

} catch (DynamoDbException $e) {
    echo "Unable to update item:\n";
    echo $e->getMessage() . "\n";
}
?>

